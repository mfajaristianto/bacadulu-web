<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conference;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::latest()->get();
        return view('landing-page.pages.conference', compact('conferences'));
    }
}