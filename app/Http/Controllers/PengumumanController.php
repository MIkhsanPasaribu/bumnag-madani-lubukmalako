<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::active()
            ->orderBy('prioritas', 'desc')
            ->latest()
            ->paginate(10);

        return view('pengumuman.index', compact('pengumuman'));
    }
}
