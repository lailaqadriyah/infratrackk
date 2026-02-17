<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realisasi extends Model
{
    use HasFactory;

    protected $table = 'realisasi';
    protected $fillable = [
        'id_opd',
        'id_tahun',
        'alokasi',
        'kegiatan',
        'sub_kegiatan',
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
