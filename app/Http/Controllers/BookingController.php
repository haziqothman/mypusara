<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client; // Add this import
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * ADMIN FUNCTIONS
     */
    
    
    public function indexAdmin(Request $request)
    {
        $status = $request->input('status');
        $query = Booking::query();

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->orderBy('eventDate', 'asc')
                         ->orderBy('eventTime', 'asc')
                         ->get();

        return view('ManageBooking.Admin.view', [
            'bookings' => $bookings,
            'selectedStatus' => $status
        ]);
    }

    

    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();
    
        // Update package status
        if ($booking->package) {
            $booking->package->status = 'tidak_tersedia';
            $booking->package->save();
        }
    
        return redirect()->back()->with('success', 'Tempahan berjaya disahkan');
    }
    
    /**
     * CUSTOMER FUNCTIONS
     */
    public function show() 
    {
        $user = Auth::id();
        $bookings = Booking::with('package')->where('user_id', $user)->get();
        return view('ManageBooking.Customer.dashboardBooking', compact('bookings'));
    }

    public function view($id)
    {
        $booking = Booking::with('package')->findOrFail($id);
        return view('ManageBooking.Customer.viewBooking', compact('booking'));
    }

    public function showAdmin() 
    {
        $user = Auth::id();
        $bookings = Booking::with('package')->where('user_id', $user)->get();
        return view('ManageBooking.Admin.dashboardBooking', compact('bookings'));
    }

    public function viewAdmin($id)
    {
        $booking = Booking::with('package')->findOrFail($id);
        return view('ManageBooking.Admin.viewBooking', compact('booking'));
    }

    public function create(Request $request, String $id)
    {
        $package = Package::findOrFail($id);
        $user = Auth::user();
    
        Log::debug('Create Booking Page Accessed', [
            'package_id' => $id,
            'user_id' => $user->id
        ]);
    
        return view('ManageBooking.Customer.createBooking', [
            'package' => $package,
            'user' => $user
        ]);
    }

  public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customerName' => 'required|string|max:255',
            'no_mykad' => 'required|string|max:20',
            'customerEmail' => 'required|email|max:255',
            'contactNumber' => 'required|string|max:20',
            'jantina_simati' => 'required|in:Lelaki,Perempuan',
            'area' => 'required|string|max:100',
            'nama_simati' => 'required|string|max:255',
            'no_mykad_simati' => 'required|string|max:20',
            'no_sijil_kematian' => 'required|string|max:20',
            'waris_address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
            'eventDate' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value)->isPast()) {
                        $fail('The event date must be in the future.');
                    }
                }
            ],
            'eventTime' => 'required|date_format:H:i',
            'eventLocation' => 'required|string|max:255',
            'death_certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Handle file upload
            $file = $request->file('death_certificate_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('death_certificates'), $fileName);

            $booking = Booking::create([
                'customerName' => $request->customerName,
                'no_mykad' => $request->no_mykad,
                'customerEmail' => $request->customerEmail,
                'contactNumber' => $request->contactNumber,
                'jantina_simati' => $request->jantina_simati,
                'area' => $request->area,
                'nama_simati' => $request->nama_simati,
                'no_mykad_simati' => $request->no_mykad_simati,
                'no_sijil_kematian' => $request->no_sijil_kematian,
                'waris_address' => $request->waris_address,
                'notes' => $request->notes,
                'eventDate' => $request->eventDate,
                'eventTime' => $request->eventTime,
                'eventLocation' => $request->eventLocation,
                'death_certificate_image' => $fileName,
                'user_id' => Auth::id(),
                'packageId' => $id,
                'status' => 'pending'
            ]);

            Log::info('Booking created successfully', ['booking_id' => $booking->id]);

            return redirect()
                ->route('ManageBooking.Customer.dashboardBooking')
                ->with([
                    'success' => 'Booking created successfully!',
                    'booking_id' => $booking->id
                ]);

        } catch (\Exception $e) {
            Log::error('Booking creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Failed to create booking: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function sendGraveDiggerNotification($booking, $package)
    {
        $graveDiggerPhone = '60123456789'; // Replace with actual grave digger's phone
        $adminPhone = '60198765432'; // Admin notification number
        
        $message = "🔨 *PERMINTAAN GALI PUSARA* 🔨\n\n" .
                "No. Pusara: *{$package->pusaraNo}*\n" .
                "Kawasan: *" . $this->getSectionName($package->section) . "*\n" .
                "Tarikh Pengebumian: *{$booking->eventDate}*\n" .
                "Masa: *{$booking->eventTime}*\n\n" .
                "Maklumat Si Mati:\n" .
                "Nama: *{$booking->nama_simati}*\n" .
                "No. KP: *{$booking->no_mykad_simati}*\n\n" .
                "Sila siapkan penggalian sebelum tarikh tersebut.";

        // Send via WhatsApp
        $this->sendWhatsApp($graveDiggerPhone, $message);
        
        // Send copy to admin
        $this->sendWhatsApp($adminPhone, $message);
        
        // Alternative SMS fallback
        $this->sendSMS($graveDiggerPhone, strip_tags($message));
    }

    private function getSectionName($section)
    {
        $sections = [
            'section_A' => 'Pintu Masuk',
            'section_B' => 'Tandas & Stor', 
            'section_C' => 'Pintu Belakang'
        ];
        return $sections[$section] ?? $section;
    }

    public function destroy(Booking $booking)
{
    try {
        // Optional: Add authorization check
        // $this->authorize('delete', $booking);
        
        $booking->delete();
        
        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Tempahan berjaya dipadam!');
    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->with('error', 'Gagal memadam tempahan: ' . $e->getMessage());
    }
}

   public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $packages = Package::all();
        
        return view('ManageBooking.Customer.editBooking', compact('booking', 'packages'));
    }

  public function update(Request $request, Booking $booking)
{
    // Validate all fields
    $validated = $request->validate([
        'customerName' => 'required|string|max:255',
        'no_mykad' => 'required|string|max:20',
        'customerEmail' => 'required|email|max:255',
        'contactNumber' => 'required|string|max:20',
        'jantina_simati' => 'required|in:Lelaki,Perempuan',
        'area' => 'required|string|max:100',
        'nama_simati' => 'required|string|max:255',
        'no_mykad_simati' => 'required|string|max:20',
        'no_sijil_kematian' => 'required|string|max:20',
        'waris_address' => 'required|string|max:255',
        'eventDate' => 'required|date|after_or_equal:today',
        'eventTime' => 'required',
        'eventLocation' => 'required|string|max:255',
        'death_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'notes' => 'nullable|string|max:500'
    ]);

    try {
        // Verify the booking belongs to the current customer
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Handle file upload if provided
        if ($request->hasFile('death_certificate_image')) {
            // Delete old image if exists
            if ($booking->death_certificate_image) {
                $oldImagePath = public_path('death_certificates/' . $booking->death_certificate_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $file = $request->file('death_certificate_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('death_certificates'), $fileName);
            $validated['death_certificate_image'] = $fileName;
        }

        // Update all fields
        $booking->update($validated);

        return redirect()
            ->route('ManageBooking.Customer.dashboardBooking')
            ->with('success', 'Tempahan berjaya dikemaskini!');

    } catch (\Exception $e) {
        return back()
            ->with('error', 'Ralat semasa mengemaskini: ' . $e->getMessage())
            ->withInput();
    }
}
    
    public function editAdmin($id)
    {
        $booking = Booking::findOrFail($id);
        $packages = Package::all();
        
        return view('ManageBooking.Admin.editBooking', compact('booking', 'packages'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);  // Find the booking by ID
    
        // Update the fields
        $booking->customerName = $request->input('customerName');
        $booking->no_mykad = $request->input('no_mykad');
        $booking->customerEmail = $request->input('customerEmail');
        $booking->contactNumber = $request->input('contactNumber');
        $booking->area = $request->input('area');
        $booking->no_mykad_simati = $request->input('no_mykad_simati');
        $booking->no_sijil_kematian = $request->input('no_sijil_kematian');
        $booking->waris_address = $request->input('waris_address');
        $booking->nama_simati = $request->input('nama_simati');
        $booking->notes = $request->input('notes');
        $booking->eventDate = $request->input('eventDate');
        $booking->eventTime = $request->input('eventTime');
        $booking->eventLocation = $request->input('eventLocation');
    
        // Save the updated booking
        $booking->save();
    
        // Redirect or return a response
        return redirect()->route('admin.bookings.index')->with('success', 'Tempahan berjaya dikemaskini');
    }

    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();

        // Update package status if no other active bookings
        if ($booking->package && !$booking->package->bookings()->where('status', '!=', 'cancelled')->exists()) {
            $booking->package->status = 'tersedia';
            $booking->package->save();
        }

        return redirect()->back()->with('success', 'Tempahan berjaya dibatalkan');
    }

   public function cancel($id)
{
    $booking = Booking::findOrFail($id);
    
    // Validate booking can be cancelled
    if ($booking->status != 'pending') {
        return back()->with('error', 'Hanya tempahan dalam proses boleh dibatalkan.');
    }
    
    $booking->update(['status' => 'cancelled']);
    
    return back()->with('success', 'Tempahan telah dibatalkan.');
}
    public function getBookedDates()
    {
        $bookedDates = Booking::pluck('eventDate');
        
        Log::debug('Booked Dates Retrieved', [
            'count' => count($bookedDates)
        ]);
        
        return response()->json($bookedDates);
    }

    public function notifyGraveDigger(Request $request, $id)
    {
        Log::debug('Starting notification', ['request' => $request->all()]);
    
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            
            Log::debug('Twilio Credentials', [
                'sid' => $sid,
                'token_exists' => !empty($token),
                'whatsapp_number' => config('services.twilio.whatsapp_number')
            ]);
    
            if (empty($sid) || empty($token)) {
                throw new \Exception('Twilio credentials missing');
            }
    
            $twilio = new Client($sid, $token);
            
            $formattedNumber = $this->formatPhone($request->grave_digger_phone);
            $whatsappNumber = 'whatsapp:' . $formattedNumber;
            $fromNumber = 'whatsapp:' . config('services.twilio.whatsapp_number');
            
            Log::debug('Sending message', [
                'to' => $whatsappNumber,
                'from' => $fromNumber,
                'message' => substr($request->message, 0, 50) . '...'
            ]);
    
            $message = $twilio->messages->create(
                $whatsappNumber,
                [
                    'from' => $fromNumber,
                    'body' => $request->message
                ]
            );
    
            Log::info('Message sent successfully', ['message_sid' => $message->sid]);
            
            return back()->with('success', 'Pemberitahuan telah dihantar!');
    
        } catch (\Exception $e) {
            Log::error('Notification failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Failed: ' . $e->getMessage());
        }
    }
    
    private function formatPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle Malaysian numbers
        if (str_starts_with($phone, '1') && strlen($phone) === 10) {
            return '60' . $phone;
        }
        
        if (str_starts_with($phone, '01') && strlen($phone) === 11) {
            return '6' . $phone;
        }
        
        if (str_starts_with($phone, '0') && strlen($phone) === 10) {
            return '60' . substr($phone, 1);
        }
        
        return $phone;
    }

      /*------------------------------------------
    Admin Methods
    --------------------------------------------*/
    // public function indexAdmin()
    // {
    //     $bookings = Booking::with(['customer', 'package'])->latest()->get();
    //     return view('admin.bookings.index', compact('bookings'));
    // }


    }