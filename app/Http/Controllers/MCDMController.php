<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class MCDMController extends Controller
{
    public function showCriteriaForm()
    {
        return view('MCDM.criteria_form');
    }

    public function processSelection(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'proximity' => 'required|in:very_important,important,not_important',
            'accessibility' => 'required|in:excellent,good,poor',
            'pathway_condition' => 'required|in:wide_paved,narrow_paved,unpaved',
            'soil_condition' => 'required|in:excellent,good,poor',
            'drainage' => 'required|in:excellent,good,poor',
            'shade' => 'required|in:full_shade,partial_shade,no_shade'
        ]);
    
        // Get only truly available packages (status = tersedia and no active bookings)
        $packages = Package::where('status', 'tersedia')
            ->whereDoesntHave('bookings', function($query) {
                $query->where('status', '!=', 'cancelled');
            })
            ->get();
    
        // Apply MCDM algorithm
        $rankedPackages = $this->applyMCDM($packages, $validated);
    
        return view('MCDM.results', [
            'packages' => $rankedPackages,
            'criteria' => $validated
        ]);
    }
    private function applyMCDM($packages, $criteria)
    {
        // Step 1: Define criteria weights based on user priorities
        $weights = $this->calculateWeights($criteria);

        // Step 2: Score each package
        $scoredPackages = $packages->map(function ($package) use ($weights, $criteria) {
            $score = 0;
            
            // Proximity score
            $proximityScore = $this->calculateProximityScore($package->proximity_rating, $criteria['proximity']);
            $score += $proximityScore * $weights['proximity'];
            
            // Accessibility score
            $accessibilityScore = $this->calculateAccessibilityScore($package->accessibility_rating, $criteria['accessibility']);
            $score += $accessibilityScore * $weights['accessibility'];
            
            // Pathway condition score
            $pathwayScore = $this->calculatePathwayScore($package->pathway_condition, $criteria['pathway_condition']);
            $score += $pathwayScore * $weights['pathway'];
            
            // Soil condition score
            $soilScore = $this->calculateSoilScore($package->soil_condition, $criteria['soil_condition']);
            $score += $soilScore * $weights['soil'];
            
            // Drainage score
            $drainageScore = $this->calculateDrainageScore($package->drainage_rating, $criteria['drainage']);
            $score += $drainageScore * $weights['drainage'];
            
            // Shade score
            $shadeScore = $this->calculateShadeScore($package->shade_coverage, $criteria['shade']);
            $score += $shadeScore * $weights['shade'];
            
            return [
                'package' => $package,
                'score' => $score,
                'proximity_score' => $proximityScore,
                'accessibility_score' => $accessibilityScore,
                'pathway_score' => $pathwayScore,
                'soil_score' => $soilScore,
                'drainage_score' => $drainageScore,
                'shade_score' => $shadeScore
            ];
        });

        // Step 3: Sort by score (descending)
        return $scoredPackages->sortByDesc('score')->values();
    }

    private function applyMcdmAlgorithm($packages, $criteria)
{
    $weights = $this->calculateMcdmWeights($criteria);

    $scoredPackages = $packages->map(function ($package) use ($weights, $criteria) {
        $score = 0;
        
        // Using your existing field names from the package table
        $score += $this->calculateProximityScore($package->proximity_rating, $criteria['proximity']) * $weights['proximity'];
        $score += $this->calculateAccessibilityScore($package->accessibility_rating, $criteria['accessibility']) * $weights['accessibility'];
        $score += $this->calculatePathwayScore($package->pathway_condition, $criteria['pathway_condition']) * $weights['pathway'];
        $score += $this->calculateSoilScore($package->soil_condition, $criteria['soil_condition']) * $weights['soil'];
        $score += $this->calculateDrainageScore($package->drainage_rating, $criteria['drainage']) * $weights['drainage'];
        $score += $this->calculateShadeScore($package->shade_coverage, $criteria['shade']) * $weights['shade'];
        
        return [
            'package' => $package,
            'score' => round($score, 2),
            // Keep your existing score details structure
            'proximity_score' => $this->calculateProximityScore($package->proximity_rating, $criteria['proximity']),
            'accessibility_score' => $this->calculateAccessibilityScore($package->accessibility_rating, $criteria['accessibility']),
            'pathway_score' => $this->calculatePathwayScore($package->pathway_condition, $criteria['pathway_condition']),
            'soil_score' => $this->calculateSoilScore($package->soil_condition, $criteria['soil_condition']),
            'drainage_score' => $this->calculateDrainageScore($package->drainage_rating, $criteria['drainage']),
            'shade_score' => $this->calculateShadeScore($package->shade_coverage, $criteria['shade'])
        ];
    });

    return $scoredPackages->sortByDesc('score')->values();
}

    private function calculateWeights($criteria)
    {
        // Base weights (can be adjusted)
        $weights = [
            'proximity' => 0.25,
            'accessibility' => 0.25,
            'pathway' => 0.15,
            'soil' => 0.15,
            'drainage' => 0.10,
            'shade' => 0.10
        ];
        
        // Adjust weights based on user priorities
        if ($criteria['proximity'] === 'very_important') {
            $weights['proximity'] = 0.35;
            $weights['accessibility'] = 0.20;
        }
        
        if ($criteria['soil_condition'] === 'excellent') {
            $weights['soil'] = 0.25;
            $weights['drainage'] = 0.15;
        }
        
        // Normalize to ensure total = 1
        $total = array_sum($weights);
        foreach ($weights as &$weight) {
            $weight = $weight / $total;
        }
        
        return $weights;
    }

    private function calculateProximityScore($packageRating, $userPriority)
    {
        $scores = [
            'very_important' => ['high' => 1, 'medium' => 0.6, 'low' => 0.2],
            'important' => ['high' => 0.8, 'medium' => 1, 'low' => 0.5],
            'not_important' => ['high' => 0.5, 'medium' => 0.8, 'low' => 1]
        ];
        
        return $scores[$userPriority][$packageRating] ?? 0.5;
    }

    private function calculateAccessibilityScore($packageRating, $userPreference)
    {
        $scores = [
            'excellent' => ['excellent' => 1, 'good' => 0.6, 'poor' => 0.2],
            'good' => ['excellent' => 0.8, 'good' => 1, 'poor' => 0.4],
            'poor' => ['excellent' => 0.5, 'good' => 0.7, 'poor' => 1]
        ];
        
        return $scores[$userPreference][$packageRating] ?? 0.5;
    }

    private function calculatePathwayScore($packageCondition, $userPreference)
    {
        $scores = [
            'wide_paved' => ['wide_paved' => 1, 'narrow_paved' => 0.7, 'unpaved' => 0.3],
            'narrow_paved' => ['wide_paved' => 0.8, 'narrow_paved' => 1, 'unpaved' => 0.5],
            'unpaved' => ['wide_paved' => 0.4, 'narrow_paved' => 0.6, 'unpaved' => 1]
        ];
        
        return $scores[$userPreference][$packageCondition] ?? 0.5;
    }

    private function calculateSoilScore($packageCondition, $userPreference)
    {
        $scores = [
            'excellent' => ['excellent' => 1, 'good' => 0.6, 'poor' => 0.1],
            'good' => ['excellent' => 0.7, 'good' => 1, 'poor' => 0.3],
            'poor' => ['excellent' => 0.4, 'good' => 0.6, 'poor' => 1]
        ];
        
        return $scores[$userPreference][$packageCondition] ?? 0.5;
    }

    private function calculateDrainageScore($packageRating, $userPreference)
    {
        $scores = [
            'excellent' => ['excellent' => 1, 'good' => 0.5, 'poor' => 0],
            'good' => ['excellent' => 0.8, 'good' => 1, 'poor' => 0.2],
            'poor' => ['excellent' => 0.6, 'good' => 0.8, 'poor' => 1]
        ];
        
        return $scores[$userPreference][$packageRating] ?? 0.5;
    }

    private function calculateShadeScore($packageCoverage, $userPreference)
    {
        $scores = [
            'full_shade' => ['full' => 1, 'partial' => 0.6, 'none' => 0.2],
            'partial_shade' => ['full' => 0.7, 'partial' => 1, 'none' => 0.4],
            'no_shade' => ['full' => 0.3, 'partial' => 0.6, 'none' => 1]
        ];
        
        return $scores[$userPreference][$packageCoverage] ?? 0.5;
    }


    public function processMcdm(Request $request)
    {
        $validated = $request->validate([
            // ... your existing validation rules ...
        ]);

        // Get only truly available packages
        $packages = Package::where('status', 'tersedia')
            ->whereDoesntHave('activeBookings')
            ->with('bookings') // Optional: eager load if needed
            ->get();

        // Debug: Check what's being returned
        logger()->info('MCDM Available Packages', [
            'count' => $packages->count(),
            'package_ids' => $packages->pluck('id'),
            'first_package' => $packages->first() ? $packages->first()->toArray() : null
        ]);

        $rankedPackages = $this->applyMcdmAlgorithm($packages, $validated);

        return view('MCDM.results', [
            'packages' => $rankedPackages,
            'criteria' => $validated
        ]);
    }
    // Temporary debug method - add this to your controller
    public function debugBookedPackages()
    {
        $bookedPackageIds = DB::table('bookings')
            ->where('status', '!=', 'cancelled')
            ->pluck('packageId')
            ->toArray();

        $availablePackages = Package::where('status', 'tersedia')
            ->whereDoesntHave('bookings', function($query) {
                $query->where('status', '!=', 'cancelled');
            })
            ->get();

        return response()->json([
            'booked_package_ids' => $bookedPackageIds,
            'available_packages_count' => $availablePackages->count(),
            'available_packages' => $availablePackages->pluck('id')
        ]);
    }

    // Add these helper methods to your controller

/**
 * Verify package availability status
 */
    public function verifyPackageAvailability($packageId)
    {
        $package = Package::with(['bookings' => function($q) {
            $q->where('status', '!=', 'cancelled');
        }])->find($packageId);

        return response()->json([
            'package_id' => $packageId,
            'status' => $package->status,
            'is_available' => $package->status === 'tersedia' && $package->bookings->isEmpty(),
            'active_bookings' => $package->bookings
        ]);
    }

    /**
     * List all unavailable packages
     */
    public function listUnavailablePackages()
    {
        $unavailable = Package::where('status', '!=', 'tersedia')
            ->orWhereHas('bookings', function($q) {
                $q->where('status', '!=', 'cancelled');
            })
            ->get();

        return response()->json([
            'unavailable_packages' => $unavailable->map(function($pkg) {
                return [
                    'id' => $pkg->id,
                    'pusaraNo' => $pkg->pusaraNo,
                    'status' => $pkg->status,
                    'bookings' => $pkg->bookings->where('status', '!=', 'cancelled')
                ];
            })
        ]);
    }
}