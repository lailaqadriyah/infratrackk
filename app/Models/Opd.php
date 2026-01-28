<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $table = 'opd';
    protected $fillable = ['nama_opd'];

    public function renjas()
    {
        return $this->hasMany(Renja::class, 'id_opd');
    }

    public function rkpds()
    {
        return $this->hasMany(Rkpd::class, 'id_opd');
    }
}
