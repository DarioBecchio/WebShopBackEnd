<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Finish;

class FinishSeeder extends Seeder
{
    public function run(): void
    {
        $finishes = ['Opaco', 'Satinato', 'Lucido', 'Metallico', 'Naturale', 'Effetto velo'];

        foreach ($finishes as $finish) {
            Finish::create(['name' => $finish]);
        }
    }
}