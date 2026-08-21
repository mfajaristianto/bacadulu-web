<?php

namespace App\Http\Controllers;

use App\Models\Conference;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::query()
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'landing-page.pages.conference',
            compact('conferences')
        );
    }
}