<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InformationAdminController extends Controller
{
    public function index()
    {
        $informations = Information::query()
            ->orderByDesc('is_pinned')
            ->orderByDesc('pinned_at')
            ->latest('created_at')
            ->get();

        return view(
            'admin.informations.index',
            compact('informations')
        );
    }

    public function create()
    {
        return view('admin.informations.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateInformation($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('uploads/informations', 'public');
        }

        $isPinned = $request->boolean('is_pinned');

        DB::transaction(function () use ($data, $isPinned) {
            if ($isPinned) {
                $this->clearPinnedInformation();
            }

            $data['is_pinned'] = $isPinned;
            $data['pinned_at'] = $isPinned ? now() : null;

            Information::create($data);
        });

        return redirect()
            ->route('admin.informations.index')
            ->with(
                'success',
                $isPinned
                    ? 'Informasi berhasil disimpan dan dijadikan informasi pilihan.'
                    : 'Informasi berhasil disimpan.'
            );
    }

    public function edit(Information $information)
    {
        return view(
            'admin.informations.edit',
            compact('information')
        );
    }

    public function update(
        Request $request,
        Information $information
    ) {
        $data = $this->validateInformation($request);

        if ($request->hasFile('image')) {
            if (
                $information->image &&
                Storage::disk('public')->exists($information->image)
            ) {
                Storage::disk('public')->delete($information->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('uploads/informations', 'public');
        }

        $isPinned = $request->boolean('is_pinned');

        DB::transaction(
            function () use (
                $information,
                $data,
                $isPinned
            ) {
                if ($isPinned) {
                    $this->clearPinnedInformation(
                        $information->id
                    );
                }

                $data['is_pinned'] = $isPinned;

                if ($isPinned) {
                    $data['pinned_at'] =
                        $information->is_pinned &&
                        $information->pinned_at
                            ? $information->pinned_at
                            : now();
                } else {
                    $data['pinned_at'] = null;
                }

                $information->update($data);
            }
        );

        return redirect()
            ->route('admin.informations.index')
            ->with(
                'success',
                $isPinned
                    ? 'Informasi berhasil diperbarui dan dijadikan informasi pilihan.'
                    : 'Informasi berhasil diperbarui.'
            );
    }

    public function togglePin(Information $information)
    {
        if ($information->is_pinned) {
            $information->update([
                'is_pinned' => false,
                'pinned_at' => null,
            ]);

            return redirect()
                ->route('admin.informations.index')
                ->with(
                    'success',
                    'Informasi berhasil dilepas dari informasi pilihan.'
                );
        }

        DB::transaction(function () use ($information) {
            $this->clearPinnedInformation(
                $information->id
            );

            $information->update([
                'is_pinned' => true,
                'pinned_at' => now(),
            ]);
        });

        return redirect()
            ->route('admin.informations.index')
            ->with(
                'success',
                'Informasi berhasil dijadikan informasi pilihan.'
            );
    }

    public function destroy(Information $information)
    {
        if (
            $information->image &&
            Storage::disk('public')->exists($information->image)
        ) {
            Storage::disk('public')->delete($information->image);
        }

        $information->delete();

        return redirect()
            ->route('admin.informations.index')
            ->with(
                'success',
                'Informasi berhasil dihapus.'
            );
    }

    private function validateInformation(Request $request): array
    {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'content' => [
                'required',
                'string',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
            'is_pinned' => [
                'nullable',
                'boolean',
            ],
        ]);
    }

    private function clearPinnedInformation(
        ?int $exceptId = null
    ): void {
        Information::query()
            ->where('is_pinned', true)
            ->when(
                $exceptId,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $exceptId
                )
            )
            ->update([
                'is_pinned' => false,
                'pinned_at' => null,
            ]);
    }
}