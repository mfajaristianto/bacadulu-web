<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::latest()->get();
        return view('landing-page.pages.publisher', compact('publishers'));
    }
}