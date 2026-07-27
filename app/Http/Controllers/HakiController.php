<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HakiController extends Controller
{
    public function index()
    {
        return view('landing-page.pages.haki');
    }
}