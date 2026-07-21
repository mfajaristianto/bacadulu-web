<?php

namespace App\Http\Controllers;

use App\Models\Jurnal; // Pastikan Model-nya dipanggil

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::all(); // Mengambil semua data dari database
        return view('jurnal', compact('jurnals')); // Mengirim data ke file bernama jurnal.blade.php
    }
}

?>