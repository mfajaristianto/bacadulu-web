<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller {
    public function show(string $slug)
    {
        $members = config('team.members');

        $member = collect($members)->firstWhere('slug', $slug);

        if (!$member) {
            abort(404);
        }

        return view('team.show', ['item' => $member, 
        ]);
    }
}