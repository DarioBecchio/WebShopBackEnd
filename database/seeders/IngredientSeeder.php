<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['inci_name' => 'AQUA', 'common_name' => 'Acqua', 'function_description' => 'Solvente / base acquosa', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'GLYCERIN', 'common_name' => 'Glicerina', 'function_description' => 'Umettante', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'NIACINAMIDE', 'common_name' => 'Vitamina B3', 'function_description' => 'Attivo lenitivo e schiarente', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'RETINOL', 'common_name' => 'Vitamina A', 'function_description' => 'Attivo anti-età', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'ASCORBIC ACID', 'common_name' => 'Vitamina C', 'function_description' => 'Antiossidante, schiarente', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'PARFUM', 'common_name' => 'Profumo', 'function_description' => 'Agente profumante', 'is_allergen' => true, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'LIMONENE', 'common_name' => null, 'function_description' => 'Componente profumante naturale', 'is_allergen' => true, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'LINALOOL', 'common_name' => null, 'function_description' => 'Componente profumante naturale', 'is_allergen' => true, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'BHT', 'common_name' => null, 'function_description' => 'Antiossidante / conservante', 'is_allergen' => false, 'is_endocrine_disruptor' => true],
            ['inci_name' => 'CYCLOPENTASILOXANE', 'common_name' => 'Siliconi', 'function_description' => 'Emolliente / agente filmogeno', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'TITANIUM DIOXIDE', 'common_name' => null, 'function_description' => 'Pigmento / filtro UV fisico', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
            ['inci_name' => 'MICA', 'common_name' => null, 'function_description' => 'Pigmento perlescente', 'is_allergen' => false, 'is_endocrine_disruptor' => false],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}