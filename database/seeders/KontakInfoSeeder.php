<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KontakInfo;

class KontakInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KontakInfo::updateOrCreate(
            ['id' => 1],
            [
                'telepon' => '0755-xxxxxxx',
                'email' => 'bumnagmadani@gmail.com',
                'alamat' => 'Jl. Nagari Lubuk Malako, Kec. Sangir Jujuan, Kab. Solok Selatan, Sumatera Barat',
                'google_maps_embed' => '',
                'facebook' => '',
                'instagram' => '@bumnagmadani',
                'youtube' => '',
                'tiktok' => '',
                'twitter' => '',
                'whatsapp' => '08xxxxxxxxxx',
            ]
        );
    }
}
