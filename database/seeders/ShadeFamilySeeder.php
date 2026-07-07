<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShadeFamily;

class ShadeFamilySeeder extends Seeder
{
    public function run(): void
    {
        $families = [
            'Chiaro freddo', 'Chiaro neutro', 'Chiaro caldo',
            'Medio freddo', 'Medio neutro', 'Medio caldo',
            'Scuro freddo', 'Scuro neutro', 'Scuro caldo',
        ];

        foreach ($families as $family) {
            ShadeFamily::create(['name' => $family]);
        }
    }
}