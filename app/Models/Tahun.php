<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $table = 'tahun';
    protected $fillable = ['tahun'];

    public function renjas()
    {
        return $this->hasMany(Renja::class, 'id_tahun');
    }

    public function rkpds()
    {
        return $this->hasMany(Rkpd::class, 'id_tahun');
    }
}
