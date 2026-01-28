<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tahun;

class TahunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($year = 2024; $year <= 2030; $year++) {
            Tahun::create(['tahun' => $year]);
        }
    }
}
