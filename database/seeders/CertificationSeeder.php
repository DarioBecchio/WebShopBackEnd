<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certification;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $certifications = [
            'ECOCERT',
            'COSMOS Organic',
            'COSMOS Natural',
            'Vegan OK',
            'Leaping Bunny',
            'ISO 22716 (GMP Cosmetici)',
        ];

        foreach ($certifications as $cert) {
            Certification::create(['name' => $cert]);
        }
    }
}