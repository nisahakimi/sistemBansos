<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //allow mass assignment
    protected $guarded = [];

    //relationship
    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'program_id');
    }
}
