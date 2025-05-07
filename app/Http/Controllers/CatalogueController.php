<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogueController extends Controller
{
    /**
     * ADMIN FUNCTIONS
     */

    public function displayManagePackage(Request $request)
    {
        $packageQuery = Package::query();
        $search = $request->input('search');
        $filter = $request->input('filter');
    
        // Searching
        if ($search) {
            $packageQuery->where('pusaraNo', 'like', "%$search%");
        }
    
        // Handle area filter
        if ($filter && $filter !== 'all') {
            $packageQuery->where('section', $filter);
        }
    
        $package = $packageQuery->paginate(6);
    
        return view('ManageCatalogue.Admin.packageList', ['package' => $package]);
    }

    public function createPackage()
    {
        $sections = [
            'section_A' => 'Area Pintu Masuk',
            'section_B' => 'Area Tandas dan stor',
            'section_C' => 'Area pintu Belakang'
        ];
        
        $mcdmOptions = $this->getMcdmOptions();
        
        return view('ManageCatalogue.Admin.addPackage', compact('sections', 'mcdmOptions'));
    }

    public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'pusaraNo' => 'required|string|max:255|unique:packages,pusaraNo',
            'section' => 'required|string|in:section_A,section_B,section_C',
            'status' => 'required|string|in:tersedia,tidak_tersedia,dalam_penyelanggaraan',
            'packageDesc' => 'required|string',
            'packageImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // MCDM fields
            'proximity_rating' => 'required|in:high,medium,low',
            'accessibility_rating' => 'required|in:excellent,good,poor',
            'pathway_condition' => 'required|in:wide_paved,narrow_paved,unpaved',
            'soil_condition' => 'required|in:excellent,good,poor',
            'drainage_rating' => 'required|in:excellent,good,poor',
            'shade_coverage' => 'required|in:full,partial,none'
        ]);
    
        $package = new Package();
        $package->fill($validated);
        $package->userId = Auth::id();
    
        if ($request->hasFile('packageImage')) {
            $path = $request->file('packageImage')->store('package_images', 'public');
            $package->packageImage = $path;
        }
    
        $package->save();
    
        return redirect()->route('admin.display.package')
            ->with('success', 'Pusara berjaya ditambah dengan kriteria MCDM!');
    }

    public function editPackage(String $id)
    {
        $package = Package::findOrFail($id);
        $sections = [
            'section_A' => 'Area Pintu Masuk',
            'section_B' => 'Area Tandas dan stor',
            'section_C' => 'Area pintu Belakang'
        ];
        $mcdmOptions = $this->getMcdmOptions();
        
        return view('ManageCatalogue.Admin.editPackage', compact('package', 'sections', 'mcdmOptions'));
    }

    public function updatePackage(Request $request, String $id)
    {
        $package = Package::findOrFail($id);
    
        $validated = $request->validate([
            'pusaraNo' => ['required', 'string', 'max:255', 'unique:packages,pusaraNo,'.$id],
            'status' => ['required', 'in:tersedia,tidak_tersedia,dalam_penyelanggaraan'],
            'section' => ['required', 'in:section_A,section_B,section_C'],
            'packageDesc' => ['required', 'string'],
            'packageImage' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            // MCDM fields
            'proximity_rating' => 'required|in:high,medium,low',
            'accessibility_rating' => 'required|in:excellent,good,poor',
            'pathway_condition' => 'required|in:wide_paved,narrow_paved,unpaved',
            'soil_condition' => 'required|in:excellent,good,poor',
            'drainage_rating' => 'required|in:excellent,good,poor',
            'shade_coverage' => 'required|in:full,partial,none'
        ]);
    
        $package->update($validated);
    
        if ($request->hasFile('packageImage')) {
            $path = $request->file('packageImage')->store('package_images', 'public');
            $package->packageImage = $path;
            $package->save();
        }
    
        return redirect()->route('admin.display.package')
            ->with('success', 'Pusara dan kriteria MCDM berjaya dikemaskini!');
    }

    public function destroyPackage(String $id)
    {
        $package = Package::findOrFail($id);
    
        if ($package->packageImage) {
            \Storage::disk('public')->delete($package->packageImage);
        }
    
        $package->delete();
        
        return redirect()->route('admin.display.package')->with('destroy', 'Package deleted successfully!');
    }

    /**
     * CUSTOMER FUNCTIONS
     */

    public function displayPackage(Request $request)
    {
        $packageQuery = Package::where('status', 'tersedia');
        $search = $request->input('search');
        $filter = $request->input('filter');
        
        if ($search) {
            $packageQuery->where('pusaraNo', 'like', "%$search%");
        }
        
        if ($filter && $filter !== 'all') {
            $packageQuery->where('section', $filter);
        }
        
        $package = $packageQuery->paginate(12);
        return view('ManageCatalogue.Customer.packageList', compact('package'));
    }

    public function searchPusara(Request $request)
    {
        $searchQuery = $request->input('search');
        
        $results = Package::where('pusaraNo', 'like', "%$searchQuery%")
                          ->orWhere('packageDesc', 'like', "%$searchQuery%")
                          ->get();

        return view('ManageCatalogue.Customer.packageList', ['results' => $results]);
    }

    /**
     * MCDM RECOMMENDATION SYSTEM
     */

    public function showMcdmForm()
    {
        return view('ManageCatalogue.Customer.mcdmForm');
    }

    public function processMcdm(Request $request)
    {
        $validated = $request->validate([
            'proximity' => 'required|in:very_important,important,not_important',
            'accessibility' => 'required|in:excellent,good,poor',
            'pathway_condition' => 'required|in:wide_paved,narrow_paved,unpaved',
            'soil_condition' => 'required|in:excellent,good,poor',
            'drainage' => 'required|in:excellent,good,poor',
            'shade' => 'required|in:full_shade,partial_shade,no_shade'
        ]);

        $packages = Package::where('status', 'tersedia')->get();

        $rankedPackages = $this->applyMcdmAlgorithm($packages, $validated);

        return view('ManageCatalogue.Customer.mcdmResults', [
            'packages' => $rankedPackages,
            'criteria' => $validated
        ]);
    }

    /**
     * HELPER FUNCTIONS
     */

    private function getMcdmOptions()
    {
        return [
            'proximity' => [
                'high' => 'Tinggi (Dekat dengan pintu masuk)',
                'medium' => 'Sederhana (Jarak pertengahan)',
                'low' => 'Rendah (Jauh dari pintu masuk)'
            ],
            'accessibility' => [
                'excellent' => 'Cemerlang (Jalan raya baik, boleh dilalui kenderaan)',
                'good' => 'Baik (Jalan boleh dilalui tetapi mungkin sempit)',
                'poor' => 'Terhad (Hanya boleh dilalui pejalan kaki)'
            ],
            'pathway' => [
                'wide_paved' => 'Laluan luas dan berturap',
                'narrow_paved' => 'Laluan sempit tetapi berturap',
                'unpaved' => 'Laluan tanah/tanpa turapan'
            ],
            'soil' => [
                'excellent' => 'Cemerlang (Tanah keras dan dalam)',
                'good' => 'Baik (Tanah sederhana keras)',
                'poor' => 'Kurang Baik (Tanah lembut/berpasir)'
            ],
            'drainage' => [
                'excellent' => 'Cemerlang (Kawasan tinggi, tiada takungan air)',
                'good' => 'Baik (Sedikit takungan air ketika hujan lebat)',
                'poor' => 'Teruk (Kerap banjir/takungan air)'
            ],
            'shade' => [
                'full' => 'Teduhan Penuh (Ada binaan/pokok teduh)',
                'partial' => 'Teduhan Separuh (Ada pokok tetapi tidak banyak)',
                'none' => 'Tiada Teduhan (Kawasan terbuka sepenuhnya)'
            ]
        ];
    }

    private function applyMcdmAlgorithm($packages, $criteria)
    {
        $weights = $this->calculateMcdmWeights($criteria);

        $scoredPackages = $packages->map(function ($package) use ($weights, $criteria) {
            $score = 0;
            
            // Calculate scores for each criterion
            $score += $this->calculateProximityScore($package->proximity_rating, $criteria['proximity']) * $weights['proximity'];
            $score += $this->calculateAccessibilityScore($package->accessibility_rating, $criteria['accessibility']) * $weights['accessibility'];
            $score += $this->calculatePathwayScore($package->pathway_condition, $criteria['pathway_condition']) * $weights['pathway'];
            $score += $this->calculateSoilScore($package->soil_condition, $criteria['soil_condition']) * $weights['soil'];
            $score += $this->calculateDrainageScore($package->drainage_rating, $criteria['drainage']) * $weights['drainage'];
            $score += $this->calculateShadeScore($package->shade_coverage, $criteria['shade']) * $weights['shade'];
            
            return [
                'package' => $package,
                'score' => round($score, 2),
                'details' => [
                    'proximity' => $this->calculateProximityScore($package->proximity_rating, $criteria['proximity']),
                    'accessibility' => $this->calculateAccessibilityScore($package->accessibility_rating, $criteria['accessibility']),
                    'pathway' => $this->calculatePathwayScore($package->pathway_condition, $criteria['pathway_condition']),
                    'soil' => $this->calculateSoilScore($package->soil_condition, $criteria['soil_condition']),
                    'drainage' => $this->calculateDrainageScore($package->drainage_rating, $criteria['drainage']),
                    'shade' => $this->calculateShadeScore($package->shade_coverage, $criteria['shade'])
                ]
            ];
        });

        return $scoredPackages->sortByDesc('score')->values();
    }

    private function calculateMcdmWeights($criteria)
    {
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
}