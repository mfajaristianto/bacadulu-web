<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Throwable;

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
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:communities,name',
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
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $data = [
            'user_id' => auth()->id(),
            'name' => trim($validated['name']),
            'description' => trim($validated['description']),
            'status' => 'pending',
        ];

        $newImagePath = null;
        $imageColumn = $this->getImageColumn();

        try {
            if ($request->hasFile('icon') && $imageColumn) {
                $newImagePath = $request
                    ->file('icon')
                    ->store('community-icons', 'public');

                $data[$imageColumn] = $newImagePath;
            }

            $community = DB::transaction(function () use ($data) {
                $community = Community::create($data);

                $community
                    ->members()
                    ->syncWithoutDetaching([
                        auth()->id(),
                    ]);

                return $community;
            });
        } catch (Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $e;
        }

        return redirect()
            ->route('community.show', $community)
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
        if (auth()->id() !== $community->user_id) {
            abort(403);
        }

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
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $data = [
            'name' => trim($validated['name']),
            'description' => trim($validated['description']),

            // Setiap perubahan oleh pemilik harus direview ulang.
            // Ini mencegah konten yang sudah approved diubah tanpa moderasi.
            'status' => 'pending',
        ];

        $imageColumn = $this->getImageColumn();
        $oldImage = $imageColumn
            ? $community->getAttribute($imageColumn)
            : null;
        $newImagePath = null;

        try {
            if ($request->hasFile('icon') && $imageColumn) {
                $newImagePath = $request
                    ->file('icon')
                    ->store('community-icons', 'public');

                $data[$imageColumn] = $newImagePath;
            }

            $community->update($data);
        } catch (Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $e;
        }

        if (
            $newImagePath &&
            $oldImage &&
            $oldImage !== $newImagePath
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('community.show', $community)
            ->with(
                'success',
                'Perubahan berhasil disimpan dan komunitas menunggu persetujuan admin kembali.'
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