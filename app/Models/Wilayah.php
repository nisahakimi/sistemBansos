<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{


    protected $fillable = [
        'provinsi', 'kabupaten', 'kecamatan', 'kode_pos',
    ];

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'wilayah_id');
    }
}
