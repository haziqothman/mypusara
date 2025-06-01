<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client; // Add this import
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request, string $id)
    {
        $validated = $request->validate([
            'customerName' => 'required|string|max:255',
            'no_mykad' => 'required|string|max:20',
            'customerEmail' => 'required|email|max:255',
            'contactNumber' => 'required|string|max:20',
            'jantina_simati' => 'required|in:Lelaki,Perempuan',
            'area' => 'required|string|max:100',
            'nama_simati' => 'required|string|max:255',
            'no_mykad_simati' => 'required|string|max:20', // Required field
            'no_sijil_kematian' => 'required|string|max:20',
            'waris_address' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
            'eventDate' => 'required|date|after_or_equal:today',
            'eventTime' => 'required|date_format:H:i',
            'eventLocation' => 'required|string|max:255',
            'death_certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
        // Handle image upload - same approach as your package images
        $filePath = public_path('death_certificates');
        $file = $request->file('death_certificate_image');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file->move($filePath, $file_name);

       
            
        Booking::create([
           'customerName' => $validated['customerName'],
            'no_mykad' => $validated['no_mykad'],
            'customerEmail' => $validated['customerEmail'],
            'contactNumber' => $validated['contactNumber'],
            'jantina_simati' => $validated['jantina_simati'],
            'area' => $validated['area'],
            'nama_simati' => $validated['nama_simati'],
            'no_mykad_simati' => $validated['no_mykad_simati'],  // Ensure the field is included
            'no_sijil_kematian' => $validated['no_sijil_kematian'],
            'waris_address' => $validated['waris_address'],
            'notes' => $validated['notes'] ?? null,
            'eventDate' => $validated['eventDate'],
            'eventTime' => $validated['eventTime'],
            'eventLocation' => $validated['eventLocation'],
            'user_id' => Auth::id(),
            'packageId' => $id,
            'status' => 'pending',
            'death_certificate_image' => $validated['death_certificate_image'] ? $file_name : null,
        ]);
    
        return redirect()->route('ManageBooking.Customer.dashboardBooking')
        ->with('success', 'Tempahan berjaya dibuat! Notifikasi telah dihantar kepada penggali pusara.');
    
     } catch (\Exception $e) {
        return back()
            ->with('error', 'Ralat: '.$e->getMessage())
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
        function makeDevFormValidator(array $data, array $rules): array
    {
        $validator = Validator::make($data, $rules);

        $response = function () use ($validator) {
            return response()->json([
                'at' => 'form',
                'errors' => $validator->errors(),
                'data' => $validator->getData(),
            ], 422);
        };

        return [
            'validator' => $validator,
            'response' => $response,
        ];
    }

    $validation = makeDevFormValidator ($request->all(), [
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
        'eventDate' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                if (strtotime($value) < strtotime('today midnight')) {
                    $fail('The event date field must be a date after or equal to today.');
                }
            }
        ],
        'eventTime' => 'required|date_format:H:i:s',
        'eventLocation' => 'required|string|max:255',
        'death_certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

     if ($validation['validator']->fails()) {
            return $validation['response']();
        }

        $validated = $validation['validator']->validated();

    try {
        // Handle new image upload if provided
        if ($request->hasFile('death_certificate_image')) {
            // Delete old image if exists
            if ($booking->death_certificate_image) {
                $oldFilePath = public_path('death_certificates/' . $booking->death_certificate_image);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            
            // Upload new image
            $filePath = public_path('death_certificates');
            $file = $request->file('death_certificate_image');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move($filePath, $file_name);
            
            $booking->death_certificate_image = $file_name;
        }

        // Update all fields
        $booking->customerName = $validated['customerName'];
        $booking->no_mykad = $validated['no_mykad'];
        $booking->customerEmail = $validated['customerEmail'];
        $booking->contactNumber = $validated['contactNumber'];
        $booking->jantina_simati = $validated['jantina_simati'];
        $booking->area = $validated['area'];
        $booking->nama_simati = $validated['nama_simati'];
        $booking->no_mykad_simati = $validated['no_mykad_simati'];
        $booking->no_sijil_kematian = $validated['no_sijil_kematian'];
        $booking->waris_address = $validated['waris_address'];
        $booking->notes = $validated['notes'] ?? null;
        $booking->eventDate = $validated['eventDate'];
        $booking->eventTime = $validated['eventTime'];
        $booking->eventLocation = $validated['eventLocation'];
        // $booking->death_certificate_image = $validated['death_certificate_image'];

        $booking->save();

        return redirect()->route('ManageBooking.Customer.dashboardBooking')
            ->with('success', 'Tempahan berjaya dikemaskini!');

    } catch (\Exception $e) {
        // return back()
        //     ->with('error', 'Ralat: '.$e->getMessage())
        //     ->withInput();

        return response()->json([
            'error' => 'Ralat: '.$e->getMessage(),
            'data' => $request->all()
        ], 500);
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