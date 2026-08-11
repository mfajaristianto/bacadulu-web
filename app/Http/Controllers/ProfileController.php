<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::with(['posts' => function($q){ $q->latest(); }])->findOrFail($id);
        return view('user.profile', compact('user'));
    }

    public function edit()
    {
        return view('user.edit-profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));
        return redirect()->route('user.profile', $user->id)->with('success', 'Profil berhasil diupdate!');
    }
}