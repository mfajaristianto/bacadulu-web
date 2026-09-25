<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthorVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthorVerificationAdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $allowedStatuses = [
            'pending',
            'approved',
            'rejected',
            'all',
        ];

        $status = $request->string('status')->toString();

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $query = AuthorVerification::query()
            ->with([
                'user',
                'reviewer',
            ])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $verifications = $query
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'pending' => AuthorVerification::where(
                'status',
                'pending'
            )->count(),

            'approved' => AuthorVerification::where(
                'status',
                'approved'
            )->count(),

            'rejected' => AuthorVerification::where(
                'status',
                'rejected'
            )->count(),

            'all' => AuthorVerification::count(),
        ];

        return view(
            'admin.author-verifications.index',
            compact(
                'verifications',
                'status',
                'counts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LIHAT BUKTI PRIVATE
    |--------------------------------------------------------------------------
    */

    public function evidence(
        AuthorVerification $verification
    ) {
        if (!$verification->evidence_path) {
            abort(404);
        }

        $disk = Storage::disk('local');

        if (!$disk->exists(
            $verification->evidence_path
        )) {
            abort(404);
        }

        $path = $disk->path(
            $verification->evidence_path
        );

        $mime = $disk->mimeType(
            $verification->evidence_path
        ) ?: 'application/octet-stream';

        $filename =
            $verification->evidence_original_name
            ?: basename(
                $verification->evidence_path
            );

        return response()->file(
            $path,
            [
                'Content-Type' => $mime,

                'Content-Disposition' =>
                    'inline; filename="' .
                    str_replace(
                        ['"', "\r", "\n"],
                        '',
                        $filename
                    ) .
                    '"',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(
        Request $request,
        AuthorVerification $verification
    ) {
        if (!$verification->isPending()) {
            return back()->with(
                'admin_verification_error',
                'Pengajuan ini sudah pernah diproses.'
            );
        }

        $validated = $request->validate([
            'admin_note' => [
                'nullable',
                'string',
                'max:1500',
            ],
        ]);

        $verification->update([
            'status' => 'approved',

            'admin_note' =>
                $validated['admin_note']
                ?? null,

            'reviewed_by' =>
                Auth::guard('admin')->id(),

            'reviewed_at' =>
                now(),
        ]);

        return back()->with(
            'admin_verification_success',
            'Penulis berhasil diverifikasi.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        AuthorVerification $verification
    ) {
        if (!$verification->isPending()) {
            return back()->with(
                'admin_verification_error',
                'Pengajuan ini sudah pernah diproses.'
            );
        }

        $validated = $request->validate([
            'admin_note' => [
                'required',
                'string',
                'max:1500',
            ],
        ], [
            'admin_note.required' =>
                'Alasan penolakan wajib diisi.',
        ]);

        $verification->update([
            'status' => 'rejected',

            'admin_note' =>
                $validated['admin_note'],

            'reviewed_by' =>
                Auth::guard('admin')->id(),

            'reviewed_at' =>
                now(),
        ]);

        return back()->with(
            'admin_verification_success',
            'Pengajuan verifikasi berhasil ditolak.'
        );
    }
}