<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Booking;
use App\Models\Package; // Corrected the class name to 'Package' if this is the intended model
use Carbon\Carbon; // Import the Carbon class for date manipulation
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::with('package')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();
                    
        return view('home', compact('bookings'));
    }
    
    public function adminHome()
    {
        // Calculate statistics
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_approvals' => Booking::where('status', 'pending')->count(),
            'available_graves' => Package::where('status', 'tersedia')->count(),
            'grave_utilization' => Package::count() > 0 
                ? round((Package::count() - Package::where('status', 'available')->count()) / Package::count() * 100, 2)
                : 0,
            'new_bookings_today' => Booking::whereDate('created_at', today())->count(),
            'completed_burials' => Booking::where('status', 'confirmed')
                                      ->whereDate('eventDate', '<=', today())
                                      ->count()
        ];
    
        // Generate booking trends for chart
        $bookingStats = [
            'months' => [],
            'counts' => []
        ];
    
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $bookingStats['months'][] = $date->format('M Y');
            $bookingStats['counts'][] = Booking::whereYear('created_at', $date->year)
                                         ->whereMonth('created_at', $date->month)
                                         ->count();
        }
    
        // Booking status distribution
        $statusStats = [
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count()
        ];
    
        // Recent bookings
        $recentBookings = Booking::with(['user', 'package'])
                            ->latest()
                            ->take(5)
                            ->get();
    
        return view('adminHome', [
            'stats' => $stats,
            'bookingStats' => $bookingStats,
            'statusStats' => $statusStats,
            'recentBookings' => $recentBookings
        ]);
    }

    
    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:bookings,financial,inventory,maintenance',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:pdf,excel,csv'
        ]);
    
        // Generate report based on type
        switch ($request->report_type) {
            case 'bookings':
                $data = Booking::with(['user', 'package'])
                         ->whereBetween('created_at', [$request->start_date, $request->end_date])
                         ->get();
                $view = 'reports.bookings';
                $filename = 'bookings_report_'.now()->format('YmdHis');
                break;
                
            case 'financial':
                $data = Payment::with(['booking.user', 'booking.package'])
                         ->whereBetween('created_at', [$request->start_date, $request->end_date])
                         ->get();
                $view = 'reports.financial';
                $filename = 'financial_report_'.now()->format('YmdHis');
                break;
                
            // Add other report types as needed
        }
    
        // Return in requested format
        if ($request->format == 'pdf') {
            $pdf = PDF::loadView($view, compact('data', 'request'));
            return $pdf->download($filename.'.pdf');
        } elseif ($request->format == 'excel') {
            return Excel::download(new ReportExport($data), $filename.'.xlsx');
        } else {
            return Excel::download(new ReportExport($data), $filename.'.csv', \Maatwebsite\Excel\Excel::CSV);
        }
    }
    
    // For showing a single booking
    public function show($id)
    {
        $booking = Booking::with('package')->findOrFail($id);
        return view('bookings.show', compact('booking')); // Make sure to use correct view name
    }
}
