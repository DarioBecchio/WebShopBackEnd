<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinConcern;

class SkinConcernSeeder extends Seeder
{
    public function run(): void
    {
        $concerns = [
            ['code' => 'acne', 'label' => 'Acne e imperfezioni', 'description' => 'Tendenza a comedoni, punti neri e brufoli.'],
            ['code' => 'aging', 'label' => 'Rughe e segni del tempo', 'description' => 'Perdita di elasticità e comparsa di rughe.'],
            ['code' => 'hyperpigmentation', 'label' => 'Macchie scure', 'description' => 'Iperpigmentazione e discromie cutanee.'],
            ['code' => 'redness', 'label' => 'Rossori e couperose', 'description' => 'Arrossamenti e sensibilità vascolare.'],
            ['code' => 'enlarged_pores', 'label' => 'Pori dilatati', 'description' => null],
            ['code' => 'dehydration', 'label' => 'Disidratazione', 'description' => 'Carenza di acqua negli strati cutanei superficiali.'],
            ['code' => 'dullness', 'label' => 'Opacità dell\'incarnato', 'description' => null],
            ['code' => 'elasticity_loss', 'label' => 'Perdita di elasticità', 'description' => null],
        ];

        foreach ($concerns as $concern) {
            SkinConcern::create($concern);
        }
    }
}