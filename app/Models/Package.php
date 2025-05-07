<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'pusaraNo',
        'section',
        'status',
        'proximity_rating', // high, medium, low
        'accessibility_rating', // excellent, good, poor
        'pathway_condition', // wide_paved, narrow_paved, unpaved
        'soil_condition', // excellent, good, poor
        'drainage_rating', // excellent, good, poor
        'shade_coverage', // full, partial, none
        'packageDesc',
        'packageImage',
        'userId',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'packageId');
    }

    public function isAvailable()
    {
        return $this->status === 'tersedia' && 
            !$this->bookings()
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->exists();
    }

    public function isBooked()
    {
        return $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }

    public function getProximityWidth()
    {
        return match($this->proximity_rating) {
            'high' => 90,
            'medium' => 60,
            'low' => 30,
            default => 0
        };
    }


   

    public function getAccessibilityWidth()
    {
        return match($this->accessibility_rating) {
            'excellent' => 90,
            'good' => 60,
            'poor' => 30,
            default => 0
        };
    }
    // Add similar methods for other criteria

    public function getSectionName()
    {
        return match($this->section) {
            'section_A' => 'Pintu Masuk',
            'section_B' => 'Tandas & Stor',
            'section_C' => 'Pintu Belakang',
            default => 'Tidak Dikenali'
        };
    }
    

   
    
    // Add these accessors for display purposes
  
    public function getProximityLabel()
    {
        return match($this->proximity_rating) {
            'high' => 'Sangat Dekat (50m dari pintu masuk)',
            'medium' => 'Sederhana (100m dari pintu masuk)',
            'low' => 'Agak Jauh (200m dari pintu masuk)',
            default => 'Tiada Maklumat'
        };
    }

    /**
     * Get human-readable accessibility label
     */
    public function getAccessibilityLabel()
    {
        return match($this->accessibility_rating) {
            'excellent' => 'Cemerlang (Jalan berturap, boleh dilalui kereta)',
            'good' => 'Baik (Jalan sempit, hanya pejalan kaki)',
            'poor' => 'Terhad (Laluan tanah sahaja)',
            default => 'Tiada Maklumat'
        };
    }

    /**
     * Get human-readable pathway label
     */
    public function getPathwayLabel()
    {
        return match($this->pathway_condition) {
            'wide_paved' => 'Laluan Luas & Berturap',
            'narrow_paved' => 'Laluan Sempit Berturap',
            'unpaved' => 'Laluan Tanah',
            default => 'Tiada Maklumat'
        };
    }

    /**
     * Get human-readable soil label
     */
    public function getSoilLabel()
    {
        return match($this->soil_condition) {
            'excellent' => 'Sangat Baik (Tanah keras)',
            'good' => 'Baik (Tanah sederhana)',
            'poor' => 'Kurang Baik (Tanah lembut/berpasir)',
            default => 'Tiada Maklumat'
        };
    }

    /**
     * Get human-readable drainage label
     */
    public function getDrainageLabel()
    {
        return match($this->drainage_rating) {
            'excellent' => 'Cemerlang (Tiada takungan air)',
            'good' => 'Baik (Sedikit takungan ketika hujan)',
            'poor' => 'Teruk (Kerap banjir)',
            default => 'Tiada Maklumat'
        };
    }

    /**
     * Get human-readable shade label
     */
    public function getShadeLabel()
    {
        return match($this->shade_coverage) {
            'full' => 'Teduhan Penuh (Ada pokok/binaan)',
            'partial' => 'Teduhan Separuh',
            'none' => 'Tiada Teduhan',
            default => 'Tiada Maklumat'
        };
    }

    // Accessor methods for display text
    public function getProximityTextAttribute()
    {
        return [
            'high' => 'Dekat dengan pintu masuk',
            'medium' => 'Jarak pertengahan',
            'low' => 'Jauh dari pintu masuk'
        ][$this->proximity_rating] ?? 'Unknown';
    }

    public function getAccessibilityTextAttribute()
    {
        return [
            'excellent' => 'Cemerlang (Jalan raya baik)',
            'good' => 'Baik (Jalan sempit)',
            'poor' => 'Terhad (Pejalan kaki)'
        ][$this->accessibility_rating] ?? 'Unknown';
    }

    // Add similar methods for other attributes
    public function getPathwayTextAttribute()
    {
        return [
            'wide_paved' => 'Laluan luas berturap',
            'narrow_paved' => 'Laluan sempit berturap',
            'unpaved' => 'Laluan tanah'
        ][$this->pathway_condition] ?? 'Unknown';
    }

    public function getSoilTextAttribute()
    {
        return [
            'excellent' => 'Cemerlang (Tanah keras)',
            'good' => 'Baik (Tanah sederhana)',
            'poor' => 'Kurang baik (Tanah lembut)'
        ][$this->soil_condition] ?? 'Unknown';
    }

    public function getDrainageTextAttribute()
    {
        return [
            'excellent' => 'Cemerlang (Tiada takungan)',
            'good' => 'Baik (Sedikit takungan)',
            'poor' => 'Teruk (Kerap banjir)'
        ][$this->drainage_rating] ?? 'Unknown';
    }

    public function getShadeTextAttribute()
    {
        return [
            'full' => 'Penuh teduhan',
            'partial' => 'Separuh teduhan',
            'none' => 'Tiada teduhan'
        ][$this->shade_coverage] ?? 'Unknown';
    }
}
