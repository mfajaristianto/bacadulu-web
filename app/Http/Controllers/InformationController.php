<?php

namespace App\Http\Controllers;

use App\Models\Information;

class InformationController extends Controller
{
    public function index()
    {
        $informations = Information::latest()->get();
        return view('landing-page.pages.information', compact('informations'));
    }

    public function show(Information $information)
    {
        return view('landing-page.pages.information-detail', compact('information'));
    }
}