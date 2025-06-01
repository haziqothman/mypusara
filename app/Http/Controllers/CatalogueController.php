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
        $packageQuery = Package::with(['bookings' => function($query) {
            $query->where('status', '!=', 'cancelled');
        }]);
        
        $search = $request->input('search');
        $filter = $request->input('filter');
        $statusFilter = $request->input('status_filter');
        
        // Searching
        if ($search) {
            $packageQuery->where('pusaraNo', 'like', "%$search%");
        }
        
        // Handle area filter
        if ($filter && $filter !== 'all') {
            $packageQuery->where('section', $filter);
        }
        
        // Handle status filter
        if ($statusFilter) {
            if ($statusFilter === 'booked') {
                $packageQuery->whereHas('bookings', function($q) {
                    $q->where('status', 'confirmed');
                });
            } elseif ($statusFilter === 'pending') {
                $packageQuery->whereHas('bookings', function($q) {
                    $q->where('status', 'pending');
                });
            } else {
                $packageQuery->where('status', $statusFilter);
            }
        }
        
        $package = $packageQuery->paginate(6);
        
        // Append all parameters to pagination links
        $package->appends([
            'filter' => $request->filter,
            'search' => $request->search,
            'status_filter' => $request->status_filter
        ]);
        
        return view('ManageCatalogue.Admin.packageList', ['package' => $package]);
    }
   public function createPackage()
    {
        $sections = [
            'section_A' => 'Area Pintu Masuk (A)',
            'section_B' => 'Area Tandas dan stor (B)',
            'section_C' => 'Area pintu Belakang (C)'
        ];
        
        $mcdmOptions = $this->getMcdmOptions();
        
        // Generate all possible lot numbers (A001-A100, B001-B100, C001-C100)
        $allPossibleLots = [];
        foreach (['A', 'B', 'C'] as $prefix) {
            for ($i = 1; $i <= 100; $i++) {
                $allPossibleLots[] = $prefix . str_pad($i, 3, '0', STR_PAD_LEFT);
            }
        }
        
        // Get used lot numbers
        $usedLots = Package::pluck('pusaraNo')->toArray();
        
        // Calculate available lots
        $availableLots = array_diff($allPossibleLots, $usedLots);
        
        // Get the next available lot number for each section
        $nextAvailable = [
            'A' => $this->getNextAvailableLot('A', $usedLots),
            'B' => $this->getNextAvailableLot('B', $usedLots),
            'C' => $this->getNextAvailableLot('C', $usedLots)
        ];
        
        return view('ManageCatalogue.Admin.addPackage', compact(
            'sections', 
            'mcdmOptions', 
            'availableLots',
            'nextAvailable'
        ));
    }

   private function getNextAvailableLot($prefix, $usedLots)
    {
        $maxNumber = 0;
        $pattern = '/^' . $prefix . '(\d{3})$/';
        
        foreach ($usedLots as $lot) {
            if (preg_match($pattern, $lot, $matches)) {
                $num = (int)$matches[1];
                if ($num > $maxNumber) {
                    $maxNumber = $num;
                }
            }
        }
        
        $nextNumber = min($maxNumber + 1, 100); // Don't exceed 100
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

   public function storePackage(Request $request)
    {
        $validated = $request->validate([
            'section' => 'required|string|in:section_A,section_B,section_C',
            'status' => 'required|string|in:tersedia,tidak_tersedia,dalam_penyelanggaraan',
            'packageDesc' => 'required|string',
            'packageImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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

        // Handle pusara number
        if ($request->pusaraNo === 'manual') {
            // Use manual input
            $request->validate([
                'manualPusaraNo' => [
                    'required',
                    'string',
                    'max:4',
                    'regex:/^[A-Z][0-9]{3}$/',
                    'unique:packages,pusaraNo'
                ]
            ], [
                'manualPusaraNo.regex' => 'Format nombor lot tidak sah. Sila gunakan format huruf besar diikuti 3 digit nombor (Contoh: A123, B045, Z999)',
                'manualPusaraNo.unique' => 'Nombor lot ini sudah wujud dalam sistem'
            ]);
            
            $pusaraNo = strtoupper($request->manualPusaraNo);
        } elseif ($request->pusaraNo === 'auto') {
            // Auto-generate
            $prefix = substr($request->section, -1); // Gets A, B, or C from section_A, etc.
            $usedLots = Package::pluck('pusaraNo')->toArray();
            $pusaraNo = $this->getNextAvailableLot($prefix, $usedLots);
            
            if (Package::where('pusaraNo', $pusaraNo)->exists()) {
                return back()->withInput()->withErrors([
                    'pusaraNo' => 'Nombor lot yang dijana automatik sudah wujud'
                ]);
            }
        } else {
            // Selected from dropdown
            $pusaraNo = $request->pusaraNo;
            
            if (Package::where('pusaraNo', $pusaraNo)->exists()) {
                return back()->withInput()->withErrors([
                    'pusaraNo' => 'Nombor lot pusara ini sudah digunakan'
                ]);
            }
        }

        // Add pusaraNo to validated data
        $validated['pusaraNo'] = $pusaraNo;

        $package = new Package();
        $package->fill($validated);
        $package->userId = Auth::id();
        
        if ($request->hasFile('packageImage')) {
            $path = $request->file('packageImage')->store('package_images', 'public');
            $package->packageImage = $path;
        }

        $package->save();

        return redirect()->route('admin.display.package')
            ->with('success', 'Pusara berjaya ditambah! Nombor Lot: ' . $pusaraNo);
    }

   public function editPackage(String $id)
{
    $package = Package::findOrFail($id);
    $sections = [
        'section_A' => 'Area Pintu Masuk (A)',
        'section_B' => 'Area Tandas dan stor (B)', 
        'section_C' => 'Area pintu Belakang (C)'
    ];
    
    $mcdmOptions = $this->getMcdmOptions();
    
    // Generate all possible lot numbers (A001-A100, B001-B100, C001-C100)
    $allPossibleLots = [];
    foreach (['A', 'B', 'C'] as $prefix) {
        for ($i = 1; $i <= 100; $i++) {
            $allPossibleLots[] = $prefix . str_pad($i, 3, '0', STR_PAD_LEFT);
        }
    }
    
    // Get used lot numbers excluding current package
    $usedLots = Package::where('id', '!=', $id)
                     ->pluck('pusaraNo')
                     ->toArray();
    
    return view('ManageCatalogue.Admin.editPackage', compact(
        'package',
        'sections',
        'mcdmOptions',
        'allPossibleLots',
        'usedLots'
    ));
}

   public function updatePackage(Request $request, String $id)
{
    $package = Package::findOrFail($id);

    $validated = $request->validate([
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

    // Handle pusara number
    if ($request->pusaraNo === 'manual') {
        $request->validate([
            'manualPusaraNo' => [
                'required',
                'string',
                'max:4',
                'regex:/^[A-Z][0-9]{3}$/',
                'unique:packages,pusaraNo,'.$id
            ]
        ], [
            'manualPusaraNo.regex' => 'Format nombor lot tidak sah. Sila gunakan format huruf besar diikuti 3 digit nombor (Contoh: A123, B045, Z999)',
            'manualPusaraNo.unique' => 'Nombor lot ini sudah wujud dalam sistem'
        ]);
        
        $validated['pusaraNo'] = strtoupper($request->manualPusaraNo);
    } else {
        $request->validate([
            'pusaraNo' => ['required', 'string', 'max:255', 'unique:packages,pusaraNo,'.$id]
        ]);
        $validated['pusaraNo'] = $request->pusaraNo;
    }

    // Handle image removal
    if ($request->has('removeImage')) {
        if ($package->packageImage) {
            \Storage::disk('public')->delete($package->packageImage);
            $validated['packageImage'] = null;
        }
    }

    // Handle new image upload
    if ($request->hasFile('packageImage')) {
        // Delete old image if exists
        if ($package->packageImage) {
            \Storage::disk('public')->delete($package->packageImage);
        }
        
        $path = $request->file('packageImage')->store('package_images', 'public');
        $validated['packageImage'] = $path;
    }

    $package->update($validated);

    return redirect()->route('admin.display.package')
        ->with('success', 'Pusara dan kriteria MCDM berjaya dikemaskini!');
}

    public function destroyPackage($id)
    {
        $package = Package::findOrFail($id);
        
        // Check if there are active bookings (only non-cancelled bookings)
        if ($package->bookings()->where('status', '!=', 'cancelled')->exists()) {
            return redirect()->back()
                ->with('error', 'Pusara tidak boleh dipadam kerana terdapat tempahan aktif');
        }
        
        // Delete associated image if exists
        if ($package->packageImage) {
            \Storage::disk('public')->delete($package->packageImage);
        }
        
        $package->delete();
        
        return redirect()->route('admin.display.package')
            ->with('success', 'Pusara berjaya dipadam');
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
        
        $package = $packageQuery->get();
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