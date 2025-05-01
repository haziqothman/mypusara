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

        // Get all available graves
        $packages = Package::where('status', 'tersedia')->get();

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
    // ... validation code ...
    
    $packages = Package::where('status', 'tersedia')->get();
    
    // Debug: dump package count and first package
    dd([
        'package_count' => $packages->count(),
        'first_package' => $packages->first(),
        'criteria' => $validated
    ]);
    
    $rankedPackages = $this->applyMcdmAlgorithm($packages, $validated);
    
    // ... rest of the code ...
}
}