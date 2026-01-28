<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opd;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $opdList = [
            'Badan Perencanaan Pembangunan Daerah',
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Dinas Pekerjaan Umum',
            'Dinas Pertanian',
            'Dinas Keuangan',
            'Dinas Sosial',
            'Dinas Pariwisata',
        ];

        foreach ($opdList as $opd) {
            Opd::create(['nama_opd' => $opd]);
        }
    }
}
