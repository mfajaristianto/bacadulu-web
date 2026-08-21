<?php

namespace App\Http\Controllers;

use App\Models\DataArticle;

class DataArticleController extends Controller
{
    public function index()
    {
        $dataArticles = DataArticle::query()
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'landing-page.pages.data-article',
            compact('dataArticles')
        );
    }
}