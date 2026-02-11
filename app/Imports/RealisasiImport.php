<?php

namespace App\Imports;

use App\Models\Realisasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RealisasiImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $idTahun;
    protected $idOpd;

    public function __construct($idTahun, $idOpd)
    {
        $this->idTahun = $idTahun;
        $this->idOpd = $idOpd;
    }

    public function model(array $row)
    {
        // Kolom Excel: gunakan "pagu" (sesuai permintaan),
        // namun tetap simpan ke field database "anggaran".
        // Fallback "anggaran" tetap diterima untuk kompatibilitas file lama.
        $rawPagu = $row['pagu'] ?? ($row['anggaran'] ?? 0);

        // Izinkan format seperti "Rp 1.000.000", "1.000.000", dll.
        // Buang semua karakter non-digit lalu cast ke number.
        $onlyDigits = preg_replace('/\D+/', '', (string) $rawPagu);
        $pagu = $onlyDigits !== '' ? (float) $onlyDigits : 0;

        return new Realisasi([
            'id_tahun' => $this->idTahun,
            'id_opd' => $this->idOpd,
            'program' => $row['program'] ?? null,
            'kegiatan' => $row['kegiatan'] ?? null,
            'sub_kegiatan' => $row['sub_kegiatan'] ?? null,
            'indikator' => $row['indikator'] ?? null,
            'target' => $row['target'] ?? null,
            'anggaran' => $pagu,
        ]);
    }

    public function rules(): array
    {
        return [
            'program' => 'nullable|string',
            'kegiatan' => 'nullable|string',
            'sub_kegiatan' => 'nullable|string',
            'indikator' => 'nullable|string',
            'target' => 'nullable|string',
            'pagu' => 'nullable|numeric',
            'anggaran' => 'nullable|numeric',
        ];
    }
}
