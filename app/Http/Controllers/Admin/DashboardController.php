<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\DataArticle;
use App\Models\Information;
use App\Models\Jurnal;
use App\Models\Publisher;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'informations' => Information::count(),
            'journals' => Jurnal::count(),
            'conferences' => Conference::count(),
            'publishers' => Publisher::count(),
            'data_articles' => DataArticle::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
