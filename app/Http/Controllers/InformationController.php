<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information; // Panggil model Information

class InformationController extends Controller
{
    public function index()
    {
        // Mengambil semua data information dari database, diurutkan dari yang terbaru
        $informations = Information::latest()->get();

        // Mengirim data tersebut ke file tampilan (view) di folder landing-page
        return view('landing-page.pages.information', compact('informations'));
    }
}