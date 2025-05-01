<?php

// app/Http/Controllers/GraveController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grave; // Make sure you have a Grave model
use App\Models\Booking;

class GraveController extends Controller
{
   // app/Http/Controllers/GraveController.php
public function search(Request $request)
{
    $request->validate([
        'search' => 'sometimes|string|max:50',
        'status' => 'sometimes|in:all,confirmed,pending,cancelled'
    ]);

    $query = Booking::query();
    
    if ($request->filled('search')) {
        $query->where(function($q) use ($request) {
            $q->where('nama_simati', 'like', '%'.$request->search.'%')
              ->orWhere('no_mykad_simati', 'like', '%'.$request->search.'%')
              ->orWhereHas('package', function($package) use ($request) {
                  $package->where('pusaraNo', 'like', '%'.$request->search.'%');
              });
        });
    }
    
    if ($request->status && $request->status !== 'all') {
        $query->where('status', $request->status);
    }
    
    $results = $query->with('package')->paginate(10);
    
    return view('home', compact('results'));
}
}
