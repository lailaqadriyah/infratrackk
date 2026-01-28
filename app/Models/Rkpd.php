<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rkpd extends Model
{
    use HasFactory;

    protected $table = 'rkpd';
    protected $fillable = [
        'id_opd',
        'id_tahun',
        'program',
        'kegiatan',
        'anggaran',
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
