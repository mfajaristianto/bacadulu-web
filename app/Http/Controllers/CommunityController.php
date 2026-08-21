<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CommunityController extends Controller
{
    /**
     * Menampilkan komunitas untuk user/public.
     */
    public function index()
    {
        $communities = Community::with('user')
            ->withCount('members')
            ->where('status', 'approved')
            ->latest()
            ->paginate(12);

        return view(
            'community.index',
            compact('communities')
        );
    }


    /**
     * Menampilkan form pembuatan komunitas.
     */
    public function create()
    {
        return view('community.create');
    }


    /**
     * Menyimpan komunitas baru dari user.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'icon' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA KOMUNITAS
        |--------------------------------------------------------------------------
        */

        $data = [
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => 'pending',
        ];


        /*
        |--------------------------------------------------------------------------
        | UPLOAD ICON / COVER
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('icon')) {

            $imageColumn = $this->getImageColumn();

            if ($imageColumn) {

                $data[$imageColumn] = $request
                    ->file('icon')
                    ->store(
                        'community-icons',
                        'public'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KOMUNITAS
        |--------------------------------------------------------------------------
        */

        $community = Community::create($data);


        /*
        |--------------------------------------------------------------------------
        | PEMBUAT OTOMATIS MENJADI ANGGOTA
        |--------------------------------------------------------------------------
        */

        if (method_exists($community, 'members')) {

            $community
                ->members()
                ->syncWithoutDetaching([
                    auth()->id()
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'community.show',
                $community
            )
            ->with(
                'success',
                'Komunitas berhasil dibuat dan sedang menunggu persetujuan admin.'
            );
    }


    /**
     * Detail komunitas.
     */
    public function show(Community $community)
    {
        /*
        |--------------------------------------------------------------------------
        | PROTEKSI STATUS
        |--------------------------------------------------------------------------
        |
        | Komunitas approved dapat dilihat semua orang.
        |
        | Komunitas pending / rejected hanya dapat dilihat pembuatnya.
        |--------------------------------------------------------------------------
        */

        if (
            $community->status !== 'approved' &&
            auth()->id() !== $community->user_id
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | LOAD RELASI
        |--------------------------------------------------------------------------
        */

        $community->load([
            'user',
            'members',
        ]);

        $community->loadCount('members');


        return view(
            'community.show',
            compact('community')
        );
    }


    /**
     * Form edit komunitas USER.
     */
    public function edit(Community $community)
    {
        /*
        |--------------------------------------------------------------------------
        | HANYA PEMILIK
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() !== $community->user_id
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW USER
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | BUKAN:
        | admin.communities.edit
        |
        |--------------------------------------------------------------------------
        */

        return view(
            'community.edit',
            compact('community')
        );
    }


    /**
     * Update komunitas oleh USER.
     */
    public function update(
        Request $request,
        Community $community
    ) {
        /*
        |--------------------------------------------------------------------------
        | HANYA PEMILIK
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() !== $community->user_id
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'icon' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA UPDATE
        |--------------------------------------------------------------------------
        |
        | Status TIDAK diubah oleh user.
        |
        | Status hanya dikelola admin.
        |--------------------------------------------------------------------------
        */

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
        ];


        /*
        |--------------------------------------------------------------------------
        | UPDATE ICON / COVER
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('icon')) {

            $imageColumn = $this->getImageColumn();

            if ($imageColumn) {

                /*
                |--------------------------------------------------------------------------
                | HAPUS GAMBAR LAMA
                |--------------------------------------------------------------------------
                */

                $oldImage = $community
                    ->getAttribute($imageColumn);


                if (
                    $oldImage &&
                    Storage::disk('public')->exists($oldImage)
                ) {

                    Storage::disk('public')
                        ->delete($oldImage);
                }


                /*
                |--------------------------------------------------------------------------
                | SIMPAN GAMBAR BARU
                |--------------------------------------------------------------------------
                */

                $data[$imageColumn] = $request
                    ->file('icon')
                    ->store(
                        'community-icons',
                        'public'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATABASE
        |--------------------------------------------------------------------------
        */

        $community->update($data);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT KE HALAMAN USER
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'community.show',
                $community
            )
            ->with(
                'success',
                'Komunitas berhasil diperbarui.'
            );
    }


    /**
     * User bergabung ke komunitas.
     */
    public function join(Community $community)
    {
        /*
        |--------------------------------------------------------------------------
        | HANYA KOMUNITAS APPROVED
        |--------------------------------------------------------------------------
        */

        if ($community->status !== 'approved') {

            return back()
                ->with(
                    'error',
                    'Komunitas ini belum dapat diikuti.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | TAMBAHKAN USER
        |--------------------------------------------------------------------------
        */

        $community
            ->members()
            ->syncWithoutDetaching([
                auth()->id()
            ]);


        return back()
            ->with(
                'success',
                'Anda berhasil bergabung dengan komunitas.'
            );
    }


    /**
     * User keluar dari komunitas.
     */
    public function leave(Community $community)
    {
        /*
        |--------------------------------------------------------------------------
        | PEMBUAT TIDAK BOLEH KELUAR
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() === $community->user_id
        ) {

            return back()
                ->with(
                    'error',
                    'Pemilik komunitas tidak dapat keluar dari komunitasnya sendiri.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS KEANGGOTAAN
        |--------------------------------------------------------------------------
        */

        $community
            ->members()
            ->detach(
                auth()->id()
            );


        return back()
            ->with(
                'success',
                'Anda telah keluar dari komunitas.'
            );
    }


    /**
     * Menentukan nama kolom gambar komunitas.
     *
     * Mendukung database yang menggunakan:
     *
     * icon
     * cover
     * image
     */
    private function getImageColumn(): ?string
    {
        if (
            Schema::hasColumn(
                'communities',
                'icon'
            )
        ) {
            return 'icon';
        }


        if (
            Schema::hasColumn(
                'communities',
                'cover'
            )
        ) {
            return 'cover';
        }


        if (
            Schema::hasColumn(
                'communities',
                'image'
            )
        ) {
            return 'image';
        }


        return null;
    }
}