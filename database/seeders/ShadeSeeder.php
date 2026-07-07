<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shade;
use App\Models\ShadeFamily;

class ShadeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Chiaro neutro' => [
                ['name' => 'Porcelain', 'hex_color' => '#F5E1D3'],
                ['name' => 'Ivory', 'hex_color' => '#F0DCC8'],
            ],
            'Medio neutro' => [
                ['name' => 'Beige', 'hex_color' => '#D9B98C'],
                ['name' => 'Sand', 'hex_color' => '#C9A579'],
            ],
            'Scuro neutro' => [
                ['name' => 'Caramel', 'hex_color' => '#8B5E3C'],
                ['name' => 'Mahogany', 'hex_color' => '#6B4226'],
            ],
        ];

        foreach ($data as $familyName => $shades) {
            $family = ShadeFamily::where('name', $familyName)->first();
            if (!$family) continue;

            foreach ($shades as $shade) {
                Shade::create([
                    'shade_family_id' => $family->id,
                    'name' => $shade['name'],
                    'hex_color' => $shade['hex_color'],
                ]);
            }
        }
    }
}