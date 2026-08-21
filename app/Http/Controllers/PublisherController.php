<?php

namespace App\Http\Controllers;

use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::query()
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'landing-page.pages.publisher',
            compact('publishers')
        );
    }
}