<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APBD extends Model
{
    use HasFactory;

    protected $table = 'apbd';
    protected $fillable = [
        'id_opd',
        'id_tahun',
        'kegiatan',
        'sub_kegiatan',
        'nama_sumber_dana',
        'nama_rekening',
        'pagu',
        'alokasi',
        'program',
        'nama_daerah',
        'file_path',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'id_opd');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_tahun');
    }
}
