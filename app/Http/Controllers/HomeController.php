<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\BookingsExport;
use App\Exports\GravesExport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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

    
    // Add these at the top of HomeController.php


// Add this method to the HomeController class
    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:bookings,graves,users,financial',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'format' => 'required|in:pdf,excel,csv',
            'status' => 'nullable|in:all,confirmed,pending,cancelled' // For booking reports
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : null;
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : null;
        
        $filename = $this->getFilename($request->report_type, $startDate, $endDate);

        switch ($request->report_type) {
            case 'bookings':
                $data = $this->getBookingData($request->status, $startDate, $endDate);
                $view = 'admin.reports.bookings';
                break;
                
            case 'graves':
                $data = $this->getGraveData();
                $view = 'admin.reports.graves';
                break;
                
            case 'users':
                $data = $this->getUserData();
                $view = 'admin.reports.users';
                break;
                
            case 'financial':
                $data = $this->getFinancialData($startDate, $endDate);
                $view = 'admin.reports.financial';
                break;
        }

        if ($request->format == 'pdf') {
            $pdf = PDF::loadView($view, compact('data', 'startDate', 'endDate'));
            return $pdf->download($filename.'.pdf');
        } else {
            $exportClass = $this->getExportClass($request->report_type);
            $export = new $exportClass($data, $startDate, $endDate);
            
            $format = $request->format == 'excel' ? \Maatwebsite\Excel\Excel::XLSX : \Maatwebsite\Excel\Excel::CSV;
            return Excel::download($export, $filename.'.'.$request->format, $format);
        }
    }

    private function getFilename($type, $startDate, $endDate)
    {
        $prefix = [
            'bookings' => 'Laporan_Tempahan',
            'graves' => 'Laporan_Pusara',
            'users' => 'Laporan_Pengguna',
            'financial' => 'Laporan_Kewangan'
        ][$type];
        
        $dateRange = $startDate ? '_'.$startDate->format('Ymd') : '';
        $dateRange .= $endDate ? '_hingga_'.$endDate->format('Ymd') : '';
        
        return $prefix.$dateRange.'_'.now()->format('YmdHis');
    }

    private function getBookingData($status, $startDate, $endDate)
    {
        $query = Booking::with(['user', 'package'])
                    ->when($status && $status != 'all', function($q) use ($status) {
                        return $q->where('status', $status);
                    })
                    ->when($startDate, function($q) use ($startDate, $endDate) {
                        return $q->whereBetween('created_at', [$startDate, $endDate]);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return [
            'bookings' => $query,
            'total' => $query->count(),
            'confirmed' => $query->where('status', 'confirmed')->count(),
            'pending' => $query->where('status', 'pending')->count(),
            'cancelled' => $query->where('status', 'cancelled')->count()
        ];
    }

    private function getGraveData()
    {
        $graves = Package::withCount(['bookings as total_bookings' => function($q) {
                $q->where('status', 'confirmed');
            }])
            ->orderBy('section')
            ->orderBy('pusaraNo')
            ->get();
            
        $sectionStats = [
            'section_A' => $graves->where('section', 'section_A'),
            'section_B' => $graves->where('section', 'section_B'),
            'section_C' => $graves->where('section', 'section_C')
        ];
        
        return [
            'graves' => $graves,
            'sectionStats' => $sectionStats,
            'totalGraves' => $graves->count(),
            'availableGraves' => $graves->where('status', 'tersedia')->count(),
            'maintenanceGraves' => $graves->where('status', 'dalam_penyelanggaraan')->count()
        ];
    }

    private function getUserData()
    {
        $users = User::withCount(['bookings as total_bookings'])
                ->orderBy('created_at', 'desc')
                ->get();
                
        return [
            'users' => $users,
            'totalUsers' => $users->count(),
            'activeUsers' => $users->where('total_bookings', '>', 0)->count(),
            'newUsers' => $users->where('created_at', '>=', now()->subMonth())->count()
        ];
    }

    private function getFinancialData($startDate, $endDate)
    {
        // This would depend on your payment system implementation
        // Placeholder for financial data
        return [
            'totalRevenue' => 0,
            'pendingPayments' => 0,
            'completedPayments' => 0,
            'transactions' => []
        ];
    }

    private function getExportClass($type)
    {
        return [
            'bookings' => BookingsExport::class,
            'graves' => GravesExport::class,
            'users' => UsersExport::class,
            'financial' => FinancialExport::class
        ][$type];
    }

    public function exportBookings()
    {
        $bookings = Booking::all();
        return Excel::download(new BookingsExport($bookings), 'bookings.xlsx');
    }
}
