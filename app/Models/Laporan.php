<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    //
    protected $guarded = [];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }
    //program
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}

