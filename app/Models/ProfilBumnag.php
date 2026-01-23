<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilBumnag extends Model
{
    protected $table = 'profil_bumnag';

    protected $fillable = [
        'nama_bumnag',
        'sejarah',
        'visi',
        'misi',
        'struktur_organisasi',
        'alamat',
        'telepon',
        'email',
        'website',
        'tahun_berdiri',
        'logo',
    ];
}
