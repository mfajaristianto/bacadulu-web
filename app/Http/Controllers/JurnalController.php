<?php

namespace App\Http\Controllers;

use App\Models\Jurnal; // Pastikan Model-nya dipanggil

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::all(); // Mengambil semua data dari database
        return view('landing-page.pages.jurnal', compact('jurnals')); // Diubah ke sini
    }
}