<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'Viso' => ['Fondotinta', 'Correttore', 'Cipria', 'Blush', 'Illuminante'],
            'Occhi' => ['Mascara', 'Eyeliner', 'Ombretti', 'Matite occhi'],
            'Labbra' => ['Rossetto', 'Gloss', 'Matite labbra', 'Tinte labbra'],
            'Skincare' => ['Detergenti', 'Creme viso', 'Sieri', 'Contorno occhi', 'Maschere'],
        ];

        foreach ($tree as $parentName => $children) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}