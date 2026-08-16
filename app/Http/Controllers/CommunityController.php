<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommunityController extends Controller
{
    /**
     * Display all approved communities
     */
    public function index(Request $request)
    {
        $communities = Community::approved()
            ->with('user', 'members')
            ->latest()
            ->paginate(12);

        return view('community.index', compact('communities'));
    }

    /**
     * Show create community form
     */
    public function create()
    {
        return view('community.create');
    }

    /**
     * Store a new community (status = pending)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:communities',
            'description' => 'required|string|min:10|max:1000',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'members_count' => 1,
        ];

        // Handle icon upload if provided
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('communities', 'public');
            $data['icon'] = $iconPath;
        }

        $community = Community::create($data);

        // Add creator as first member
        $community->members()->attach(auth()->id(), ['joined_at' => now()]);

        return redirect()->route('community.index')
                        ->with('success', 'Komunitas berhasil dibuat! Sedang menunggu persetujuan admin.');
    }

    /**
     * Show community detail page
     */
    public function show(Community $community)
    {
        // Only show approved communities to public
        if ($community->status !== 'approved' && auth()->id() !== $community->user_id) {
            abort(404);
        }

        $community->load('user', 'members');
        $isMember = auth()->check() ? $community->isMember(auth()->id()) : false;

        return view('community.show', compact('community', 'isMember'));
    }

    /**
     * User join community
     */
    public function join(Community $community)
    {
        // Authorization check
        if (!auth()->check()) {
            return redirect()->route('login')
                            ->with('error', 'Silakan login untuk bergabung dengan komunitas.');
        }

        if ($community->status !== 'approved') {
            return redirect()->back()->with('error', 'Komunitas ini belum disetujui.');
        }

        // Check if already member
        if ($community->isMember(auth()->id())) {
            return redirect()->back()->with('info', 'Anda sudah menjadi anggota komunitas ini.');
        }

        // Add member
        $community->members()->attach(auth()->id(), ['joined_at' => now()]);
        $community->increment('members_count');

        return redirect()->back()->with('success', 'Anda berhasil bergabung dengan komunitas!');
    }

    /**
     * User leave community
     */
    public function leave(Community $community)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($community->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'Pembuat komunitas tidak bisa meninggalkan komunitas.');
        }

        // Remove member
        $community->members()->detach(auth()->id());
        $community->decrement('members_count');

        return redirect()->back()->with('success', 'Anda berhasil meninggalkan komunitas.');
    }
}
