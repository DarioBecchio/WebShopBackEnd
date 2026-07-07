<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Size;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            ['amount' => 5, 'unit' => 'ml', 'display_label' => '5 ml'],
            ['amount' => 15, 'unit' => 'ml', 'display_label' => '15 ml'],
            ['amount' => 30, 'unit' => 'ml', 'display_label' => '30 ml'],
            ['amount' => 50, 'unit' => 'ml', 'display_label' => '50 ml'],
            ['amount' => 100, 'unit' => 'ml', 'display_label' => '100 ml'],
            ['amount' => 1.7, 'unit' => 'fl_oz', 'display_label' => '1.7 fl oz'],
            ['amount' => 10, 'unit' => 'g', 'display_label' => '10 g'],
            ['amount' => 1, 'unit' => 'piece', 'display_label' => '1 pezzo'],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}