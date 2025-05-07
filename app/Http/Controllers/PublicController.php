<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function landing()
    {
        return view('public.landing');
    }

    public function search(Request $request)
    {
        $search = trim($request->input('search'));
        
        if (empty($search)) {
            return redirect()->route('landing')->with('error', 'Sila masukkan carian');
        }

        // Search by pusaraNo first
        $results = Package::where('status', 'confirmed')
            ->where(function($query) use ($search) {
                $query->where('pusaraNo', 'like', "%$search%")
                    ->orWhereHas('bookings', function($q) use ($search) {
                        $q->where('status', 'confirmed')
                            ->where(function($innerQ) use ($search) {
                                $innerQ->where('nama_simati', 'like', "%$search%")
                                    ->orWhere('no_mykad_simati', 'like', "%$search%");
                            });
                    });
            })
            ->with(['bookings' => function($query) {
                $query->where('status', 'confirmed');
            }])
            ->orderBy('pusaraNo')
            ->paginate(10);

        // If no results, try fuzzy search
        if ($results->isEmpty() && Str::wordCount($search) > 1) {
            $searchTerms = explode(' ', $search);
            
            $results = Package::where('status', 'confirmed')
                ->whereHas('bookings', function($query) use ($searchTerms) {
                    $query->where('status', 'confirmed')
                        ->where(function($q) use ($searchTerms) {
                            foreach ($searchTerms as $term) {
                                if (strlen($term) > 2) { // Only search terms with more than 2 characters
                                    $q->orWhere('nama_simati', 'like', "%$term%");
                                }
                            }
                        });
                })
                ->with(['bookings' => function($query) use ($searchTerms) {
                    $query->where('status', 'confirmed')
                        ->where(function($q) use ($searchTerms) {
                            foreach ($searchTerms as $term) {
                                if (strlen($term) > 2) {
                                    $q->orWhere('nama_simati', 'like', "%$term%");
                                }
                            }
                        });
                }])
                ->orderBy('pusaraNo')
                ->paginate(10);
        }

        return view('public.search-results', [
            'results' => $results,
            'search' => $search,
            'searchType' => 'nama' // To distinguish between different search types
        ]);
    }

    public function show($id)
    {
        $grave = Package::with(['bookings' => function($query) {
            $query->where('status', 'confirmed');
        }])->findOrFail($id);

        return view('public.grave-details', compact('grave'));
    }
}