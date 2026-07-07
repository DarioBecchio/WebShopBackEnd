<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinType;

class SkinTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Normale', 'Secca', 'Grassa', 'Mista', 'Sensibile'];

        foreach ($types as $type) {
            SkinType::create(['name' => $type]);
        }
    }
}