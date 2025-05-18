<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PusaraLotsSeeder extends Seeder
{
    public function run()
    {
        $lots = [];
        
        // Create lots for Section A (A001-A020)
        for ($i = 1; $i <= 20; $i++) {
            $lots[] = [
                'lot_number' => 'A' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'section' => 'A',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        // Create lots for Section B (B001-B020)
        for ($i = 1; $i <= 20; $i++) {
            $lots[] = [
                'lot_number' => 'B' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'section' => 'B',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        // Create lots for Section C (C001-C020)
        for ($i = 1; $i <= 20; $i++) {
            $lots[] = [
                'lot_number' => 'C' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'section' => 'C',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        DB::table('pusara_lots')->insert($lots);
    }
}