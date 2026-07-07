<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certification;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $certifications = [
            ['code' => 'ecocert', 'name' => 'ECOCERT', 'issuing_body' => 'ECOCERT Greenlife'],
            ['code' => 'cosmos_organic', 'name' => 'COSMOS Organic', 'issuing_body' => 'COSMOS-standard AISBL'],
            ['code' => 'cosmos_natural', 'name' => 'COSMOS Natural', 'issuing_body' => 'COSMOS-standard AISBL'],
            ['code' => 'vegan_ok', 'name' => 'Vegan OK', 'issuing_body' => 'V-Label / Vegan OK'],
            ['code' => 'leaping_bunny', 'name' => 'Leaping Bunny', 'issuing_body' => 'Cruelty Free International'],
            ['code' => 'iso22716', 'name' => 'ISO 22716 (GMP Cosmetici)', 'issuing_body' => 'ISO'],
        ];

        foreach ($certifications as $cert) {
            Certification::create($cert);
        }
    }
}