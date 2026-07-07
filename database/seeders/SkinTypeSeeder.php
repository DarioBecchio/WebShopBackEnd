<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinType;

class SkinTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['code' => 'normal', 'label' => 'Normale'],
            ['code' => 'dry', 'label' => 'Secca'],
            ['code' => 'oily', 'label' => 'Grassa'],
            ['code' => 'combination', 'label' => 'Mista'],
            ['code' => 'sensitive', 'label' => 'Sensibile'],
            ['code' => 'all', 'label' => 'Tutti i tipi di pelle'],
        ];

        foreach ($types as $type) {
            SkinType::create($type);
        }
    }
}