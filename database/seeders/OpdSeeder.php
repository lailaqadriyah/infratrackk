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
            'Badan Bina Marga, Cipta Karya Dan Tata Ruang (BMCKTR)',
            'Dinas Perumahan Rakyat, Kawasan Permukiman, dan Pertanahan (Parkimtan)',
            'Dinas Dinas Sumber Daya Air dan Bina Konstruksi (SDABK)',
            'Dinas Perhubungan',
            'Dinas Dinas Energi dan Sumber Daya Mineral (ESDM)',
            'Dinas Lingkungan Hidup',
            'Dinas Badan Penanggulangan Bencana Daerah (BPBD)',
            
        ];

        foreach ($opdList as $opd) {
            Opd::create(['nama_opd' => $opd]);
        }
    }
}
