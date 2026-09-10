<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $allowedStatuses = [
            'pending',
            'approved',
            'rejected',
            'all',
        ];

        $status = $request->get('status', 'pending');

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $communities = Community::query()
            ->with('user')
            ->withCount('members')
            ->when(
                $status !== 'all',
                fn ($query) => $query->where('status', $status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.communities.index',
            compact('communities', 'status')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Resource routes yang memang tidak dipakai
    |--------------------------------------------------------------------------
    |
    | Komunitas dibuat oleh user. Method ini tetap disediakan supaya route
    | resource tidak menghasilkan 500 jika URL dipanggil langsung.
    |
    */

    public function create()
    {
        return redirect()
            ->route('admin.communities.index')
            ->with('info', 'Komunitas baru dibuat melalui akun pengguna.');
    }

    public function store(Request $request)
    {
        abort(405);
    }

    public function show(Community $community)
    {
        return redirect()
            ->route('admin.communities.edit', $community);
    }

    public function edit(Community $community)
    {
        $community->load('user');
        $community->loadCount('members');

        return view(
            'admin.communities.edit',
            compact('community')
        );
    }

    public function update(
        Request $request,
        Community $community
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:communities,name,' . $community->id,
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:1000',
            ],
            'icon' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,webp',
                'max:2048',
            ],
        ]);

        $data = [
            'name' => trim($validated['name']),
            'description' => trim($validated['description']),
        ];

        $oldIcon = $community->icon;
        $newIconPath = null;

        try {
            if ($request->hasFile('icon')) {
                $newIconPath = $request
                    ->file('icon')
                    ->store('communities', 'public');

                $data['icon'] = $newIconPath;
            }

            $community->update($data);
        } catch (Throwable $e) {
            if ($newIconPath) {
                Storage::disk('public')->delete($newIconPath);
            }

            throw $e;
        }

        if (
            $newIconPath &&
            $oldIcon &&
            $oldIcon !== $newIconPath
        ) {
            Storage::disk('public')->delete($oldIcon);
        }

        return redirect()
            ->route('admin.communities.index')
            ->with('success', 'Komunitas berhasil diperbarui.');
    }

    public function approve(Community $community)
    {
        $community->update([
            'status' => 'approved',
        ]);

        return back()->with(
            'success',
            'Komunitas disetujui dan sudah ditampilkan ke publik.'
        );
    }

    public function reject(Community $community)
    {
        $community->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'Komunitas ditolak.'
        );
    }

    public function destroy(Community $community)
    {
        $iconPath = $community->icon;

        $community->delete();

        if ($iconPath) {
            Storage::disk('public')->delete($iconPath);
        }

        return redirect()
            ->route('admin.communities.index')
            ->with('success', 'Komunitas berhasil dihapus.');
    }
}
