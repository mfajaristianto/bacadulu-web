<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\DataArticle;
use App\Models\Information;
use App\Models\Jurnal;
use App\Models\Publisher;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $informations = $query ? Information::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->get() : collect();

        $journals = $query ? Jurnal::where('judul', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->get() : collect();

        $conferences = $query ? Conference::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get() : collect();

        $publishers = $query ? Publisher::where('name', 'like', "%{$query}%")
            ->orWhere('about', 'like', "%{$query}%")
            ->get() : collect();

        $dataArticles = $query ? DataArticle::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get() : collect();

        return view('search.index', compact('query', 'informations', 'journals', 'conferences', 'publishers', 'dataArticles'));
    }
}
