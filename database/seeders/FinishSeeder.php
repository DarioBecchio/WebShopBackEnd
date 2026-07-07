<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Finish;

class FinishSeeder extends Seeder
{
    public function run(): void
    {
        $finishes = [
            ['code' => 'matte', 'label' => 'Opaco'],
            ['code' => 'satin', 'label' => 'Satinato'],
            ['code' => 'dewy', 'label' => 'Luminoso / Dewy'],
            ['code' => 'glossy', 'label' => 'Lucido'],
            ['code' => 'metallic', 'label' => 'Metallico'],
            ['code' => 'natural', 'label' => 'Naturale'],
            ['code' => 'veil', 'label' => 'Effetto velo'],
        ];

        foreach ($finishes as $finish) {
            Finish::create($finish);
        }
    }
}