<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Claim;

class ClaimSeeder extends Seeder
{
    public function run(): void
    {
        $claims = [
            ['code' => 'vegan', 'label' => 'Vegan', 'category' => 'ingredient'],
            ['code' => 'cruelty_free', 'label' => 'Cruelty-free', 'category' => 'ingredient'],
            ['code' => 'paraben_free', 'label' => 'Senza parabeni', 'category' => 'ingredient'],
            ['code' => 'silicone_free', 'label' => 'Senza siliconi', 'category' => 'ingredient'],
            ['code' => 'gluten_free', 'label' => 'Senza glutine', 'category' => 'ingredient'],
            ['code' => 'dermatologically_tested', 'label' => 'Dermatologicamente testato', 'category' => 'skin_benefit'],
            ['code' => 'nickel_tested', 'label' => 'Nickel tested', 'category' => 'skin_benefit'],
            ['code' => 'fragrance_free', 'label' => 'Senza profumo', 'category' => 'ingredient'],
            ['code' => 'palm_oil_free', 'label' => 'Formulato senza olio di palma', 'category' => 'eco'],
            ['code' => 'spf30', 'label' => 'SPF 30', 'category' => 'spf'],
            ['code' => 'hypoallergenic', 'label' => 'Ipoallergenico', 'category' => 'skin_benefit'],
        ];

        foreach ($claims as $claim) {
            Claim::create($claim);
        }
    }
}