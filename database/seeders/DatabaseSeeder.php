<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            SkinTypeSeeder::class,
            SkinConcernSeeder::class,
            FinishSeeder::class,
            ShadeFamilySeeder::class,
            ShadeSeeder::class,
            SizeSeeder::class,
            ClaimSeeder::class,
            CertificationSeeder::class,
            IngredientSeeder::class,
        ]);
    }
}