<?php

namespace App\Http\Controllers;

use App\Models\ProfilBumnag;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = ProfilBumnag::first();
        return view('profil', compact('profil'));
    }
}
