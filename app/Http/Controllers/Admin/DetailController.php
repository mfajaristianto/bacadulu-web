<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use App\Models\DataArticle;
use App\Models\Information;
use App\Models\Jurnal;
use App\Models\Publisher;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function show($type, $id)
    {
        $model = match ($type) {
            'information' => Information::findOrFail($id),
            'journal' => Jurnal::findOrFail($id),
            'conference' => Conference::findOrFail($id),
            'publisher' => Publisher::findOrFail($id),
            'data-article' => DataArticle::findOrFail($id),
            default => abort(404),
        };

        return view('admin.details.show', compact('model', 'type'));
    }
}
