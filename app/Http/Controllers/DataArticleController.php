<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataArticle;

class DataArticleController extends Controller
{
    public function index()
    {
        $dataArticles = DataArticle::latest()->get();
        return view('landing-page.pages.data-article', compact('dataArticles'));
    }
}