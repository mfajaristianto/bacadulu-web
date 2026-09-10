<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnals = Jurnal::query()
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view(
            'landing-page.pages.jurnal',
            compact('jurnals')
        );
    }
}
