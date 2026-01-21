<?php

namespace Database\Seeders;

use App\Models\TipeTiket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeTiketSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $types = ['Reguler', 'VIP', 'Early Bird'];

        foreach ($types as $name) {
            TipeTiket::firstOrCreate(['nama' => $name]);
        }
    }
}
