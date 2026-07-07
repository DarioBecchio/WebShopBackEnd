<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Claim;

class ClaimSeeder extends Seeder
{
    public function run(): void
    {
        $claims = [
            'Vegan',
            'Cruelty-free',
            'Senza parabeni',
            'Senza siliconi',
            'Senza glutine',
            'Dermatologicamente testato',
            'Nickel tested',
            'Senza profumo',
            'Formulato senza olio di palma',
        ];

        foreach ($claims as $claim) {
            Claim::create(['name' => $claim]);
        }
    }
}