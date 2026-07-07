<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            ['label' => '5 ml', 'value' => 5, 'unit' => 'ml'],
            ['label' => '15 ml', 'value' => 15, 'unit' => 'ml'],
            ['label' => '30 ml', 'value' => 30, 'unit' => 'ml'],
            ['label' => '50 ml', 'value' => 50, 'unit' => 'ml'],
            ['label' => '100 ml', 'value' => 100, 'unit' => 'ml'],
            ['label' => 'Mini / Travel size', 'value' => 10, 'unit' => 'ml'],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}