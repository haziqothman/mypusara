<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function searchBookings(Request $request)
    {
        $searchQuery = $request->input('search');
        
        $bookings = Booking::with(['package']) // Eager load package
            ->where('status', 'confirmed')
            ->where(function($query) use ($searchQuery) {
                $query->where('nama_simati', 'like', "%$searchQuery%")
                    ->orWhere('no_sijil_kematian', 'like', "%$searchQuery%")
                    ->orWhereHas('package', function($q) use ($searchQuery) {
                        $q->where('pusaraNo', 'like', "%$searchQuery%");
                    });
            })
            ->orderBy('eventDate', 'desc')
            ->paginate(10);
    
        return view('public.searchResult', [
            'bookings' => $bookings,
            'searchQuery' => $searchQuery
        ]);
    }
}

