<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinConcern;

class SkinConcernSeeder extends Seeder
{
    public function run(): void
    {
        $concerns = [
            'Acne e imperfezioni',
            'Rughe e segni del tempo',
            'Macchie scure',
            'Pori dilatati',
            'Rossori e couperose',
            'Disidratazione',
            'Opacità dell\'incarnato',
            'Perdita di elasticità',
        ];

        foreach ($concerns as $concern) {
            SkinConcern::create(['name' => $concern]);
        }
    }
}