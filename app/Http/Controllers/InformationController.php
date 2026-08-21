<?php

namespace App\Http\Controllers;

use App\Models\Information;

class InformationController extends Controller
{
    public function index()
    {
        $informations = Information::query()
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'landing-page.pages.information',
            compact('informations')
        );
    }


    public function show(Information $information)
    {
        return view(
            'landing-page.pages.information-detail',
            compact('information')
        );
    }
}