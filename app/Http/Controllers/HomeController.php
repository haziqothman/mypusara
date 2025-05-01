<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Booking;

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
        // If you want to show bookings on the home page
        $bookings = Booking::with('package')->latest()->take(5)->get(); // Example: show 5 latest
        return view('home', compact('bookings'));
    }
    
    public function adminHome(): View
    {
        $bookings = Booking::with('package')->latest()->get(); // For admin view
        return view('adminHome', compact('bookings'));
    }
    
    // For showing a single booking
    public function show($id)
    {
        $booking = Booking::with('package')->findOrFail($id);
        return view('bookings.show', compact('booking')); // Make sure to use correct view name
    }
}
