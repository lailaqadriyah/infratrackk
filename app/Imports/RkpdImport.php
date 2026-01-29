<?php

namespace App\Imports;

use App\Models\Rkpd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RkpdImport implements ToModel, WithHeadingRow, WithValidation
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
        return new Rkpd([
            'id_tahun' => $this->idTahun,
            'id_opd' => $this->idOpd,
            'program' => $row['program'] ?? null,
            'kegiatan' => $row['kegiatan'] ?? null,
            'anggaran' => $row['anggaran'] ?? 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'program' => 'nullable|string',
            'kegiatan' => 'nullable|string',
            'anggaran' => 'nullable|numeric',
        ];
    }
}
