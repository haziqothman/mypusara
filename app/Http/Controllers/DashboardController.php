<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Sample data (replace with database queries)
        $totalBookings = 120;
        $pendingBookings = 8;
        $revenue = 5000;
        $feedbackScore = 4.5;
        $recentBookings = [
            ['name' => 'John Doe', 'date' => '2024-12-20', 'pax' => 50, 'status' => 'Pending'],
            // Add more sample bookings here
        ];

        return view('dashboard.index', compact('totalBookings', 'pendingBookings', 'revenue', 'feedbackScore', 'recentBookings'));
    }
}