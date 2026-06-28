<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KawasanIndustri extends Model
{
    protected $table = 'kawasan_industri';

    protected $fillable = [
        'nama',
        'lokasi',
        'luas_lahan',
        'infrastruktur',
        'fasilitas',
        'tahun_beroperasi',
        'geom',
        'kode_kec',
    ];

    public $timestamps = false;

    public function wilayah()
    {
        return $this->belongsTo(
            WilayahAdministrasi::class,
            'kode_kec',
            'kode_kec'
        );
    }
}