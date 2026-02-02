<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk halaman Tim Pengembang
 * Menampilkan informasi tim yang mengembangkan website BUMNag Madani
 */
class TimPengembangController extends Controller
{
    /**
     * Menampilkan halaman Tim Pengembang
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data pengembang website
        $developers = [
            [
                'nama' => 'M. Ikhsan Pasaribu',
                'nim' => '23076039',
                'prodi' => 'Pendidikan Teknik Informatika',
                'title' => 'Project Manager, Full-Stack, & Generative AI Engineer',
                'foto' => 'tim-pengembang/ikhsan.jpg',
                'sosmed' => [
                    'github' => 'https://github.com/MIkhsanPasaribu',
                    'instagram' => 'https://www.instagram.com/m.ikhsanp1/',
                    'linkedin' => 'https://www.linkedin.com/in/mikhsanpasaribu/',
                    'portfolio' => 'https://mikhsanpasaribu.vercel.app/',
                ],
            ],
            [
                'nama' => 'Daffa Robbani',
                'nim' => '23076007',
                'prodi' => 'Pendidikan Teknik Informatika',
                'title' => 'Full-Stack & DevOps Engineer',
                'foto' => 'tim-pengembang/daffa.jpg',
                'sosmed' => [
                    'github' => 'https://github.com/daffarobbani18',
                    'instagram' => 'https://www.instagram.com/_dafffffa/',
                    'linkedin' => 'https://www.linkedin.com/in/daffa-robbani-584780371/',
                    'portfolio' => 'https://daffarobbani.vercel.app/',
                ],
            ],
        ];

        return view('public.tim-pengembang', compact('developers'));
    }
}
