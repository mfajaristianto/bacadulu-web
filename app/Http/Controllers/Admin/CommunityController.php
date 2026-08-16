<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    /**
     * Display all communities with filter by status
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $communities = Community::with('user', 'members')
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        return view('admin.communities.index', compact('communities', 'status'));
    }

    /**
     * Show edit form
     */
    public function edit(Community $community)
    {
        $community->load('user', 'members');
        return view('admin.communities.edit', compact('community'));
    }

    /**
     * Update community
     */
    public function update(Request $request, Community $community)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:communities,name,' . $community->id,
            'description' => 'required|string|min:10|max:1000',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Handle icon upload if provided
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($community->icon && file_exists(storage_path('app/public/' . $community->icon))) {
                unlink(storage_path('app/public/' . $community->icon));
            }
            $iconPath = $request->file('icon')->store('communities', 'public');
            $data['icon'] = $iconPath;
        }

        $community->update($data);

        return redirect()->route('admin.communities.index')
                        ->with('success', 'Komunitas berhasil diperbarui.');
    }

    /**
     * Approve community (pending -> approved)
     */
    public function approve(Community $community)
    {
        $community->update(['status' => 'approved']);

        return back()->with('success', 'Komunitas disetujui dan sudah ditampilkan ke publik.');
    }

    /**
     * Reject community (pending -> rejected)
     */
    public function reject(Community $community)
    {
        $community->update(['status' => 'rejected']);

        return back()->with('success', 'Komunitas ditolak.');
    }

    /**
     * Delete community
     */
    public function destroy(Community $community)
    {
        // Delete icon if exists
        if ($community->icon && file_exists(storage_path('app/public/' . $community->icon))) {
            unlink(storage_path('app/public/' . $community->icon));
        }

        $community->delete();

        return redirect()->route('admin.communities.index')
                        ->with('success', 'Komunitas berhasil dihapus.');
    }
}
