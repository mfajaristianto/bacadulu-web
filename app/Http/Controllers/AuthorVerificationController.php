<?php

namespace App\Http\Controllers;

use App\Models\AuthorVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class AuthorVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN VERIFIKASI PENULIS
    |--------------------------------------------------------------------------
    */

    public function show(Request $request)
    {
        $verification = $request->user()
            ->authorVerification()
            ->first();

        return view(
            'profile.author-verification',
            compact('verification')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM / KIRIM ULANG VERIFIKASI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $user = $request->user();

        $verification = $user
            ->authorVerification()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | SUDAH APPROVED
        |--------------------------------------------------------------------------
        */

        if ($verification?->status === 'approved') {
            return back()->with(
                'verification_success',
                'Akun Anda sudah berstatus Penulis Terverifikasi.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | MASIH PENDING
        |--------------------------------------------------------------------------
        */

        if ($verification?->status === 'pending') {
            return back()->withErrors([
                'verification' =>
                    'Pengajuan Anda masih menunggu pemeriksaan admin.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'institution' => [
                'required',
                'string',
                'max:255',
            ],

            'orcid_url' => [
                'nullable',
                'string',
                'max:255',
            ],

            'google_scholar_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'publication_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'evidence' => [
                Rule::requiredIf(
                    empty($verification?->evidence_path)
                ),
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:10240',
            ],

            'declaration' => [
                'required',
                'accepted',
            ],
        ], [
            'institution.required' =>
                'Institusi atau afiliasi wajib diisi.',

            'google_scholar_url.url' =>
                'Link Google Scholar tidak valid.',

            'publication_url.url' =>
                'Link publikasi atau DOI tidak valid.',

            'evidence.required' =>
                'Bukti kepenulisan wajib diunggah.',

            'evidence.mimes' =>
                'Bukti harus berupa PDF, JPG, JPEG, PNG, atau WEBP.',

            'evidence.max' =>
                'Ukuran bukti maksimal 10 MB.',

            'declaration.accepted' =>
                'Anda harus menyetujui pernyataan kepemilikan bukti.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI ORCID
        |--------------------------------------------------------------------------
        */

        $orcidUrl = $this->normaliseOrcid(
            $validated['orcid_url'] ?? null
        );

        if (
            $orcidUrl &&
            !preg_match(
                '#^https://orcid\.org/\d{4}-\d{4}-\d{4}-\d{3}[\dX]$#i',
                $orcidUrl
            )
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'orcid_url' =>
                        'Format ORCID tidak valid. Contoh: 0000-0000-0000-000X',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $data = [
            'status' => 'pending',

            'institution' =>
                trim($validated['institution']),

            'orcid_url' =>
                $orcidUrl,

            'google_scholar_url' =>
                $validated['google_scholar_url'] ?? null,

            'publication_url' =>
                $validated['publication_url'] ?? null,

            /*
            |--------------------------------------------------------------------------
            | KETIKA RESUBMIT SETELAH REJECT
            |--------------------------------------------------------------------------
            */

            'admin_note' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ];


        /*
        |--------------------------------------------------------------------------
        | PRIVATE EVIDENCE
        |--------------------------------------------------------------------------
        |
        | Disk "local" project ini mengarah ke:
        |
        | storage/app/private
        |
        | Jadi bukti TIDAK masuk public/storage.
        |
        */

        $newEvidencePath = null;

        if ($request->hasFile('evidence')) {

            $file = $request->file('evidence');

            $newEvidencePath = $file->store(
                'author-verifications/' . $user->id,
                'local'
            );

            if (!$newEvidencePath) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'evidence' =>
                            'Bukti gagal disimpan. Silakan coba kembali.',
                    ]);
            }

            $data['evidence_path'] =
                $newEvidencePath;

            $data['evidence_original_name'] =
                $file->getClientOriginalName();
        }


        /*
        |--------------------------------------------------------------------------
        | SAVE DATABASE
        |--------------------------------------------------------------------------
        */

        try {

            $oldEvidence =
                $verification?->evidence_path;

            $savedVerification =
                $user
                    ->authorVerification()
                    ->updateOrCreate(
                        [
                            'user_id' => $user->id,
                        ],
                        $data
                    );


            /*
            |--------------------------------------------------------------------------
            | HAPUS BUKTI LAMA
            |--------------------------------------------------------------------------
            */

            if (
                $newEvidencePath &&
                $oldEvidence &&
                $oldEvidence !== $newEvidencePath
            ) {
                Storage::disk('local')
                    ->delete($oldEvidence);
            }

        } catch (Throwable $exception) {

            /*
            |--------------------------------------------------------------------------
            | CLEANUP FILE BARU JIKA DB GAGAL
            |--------------------------------------------------------------------------
            */

            if ($newEvidencePath) {
                Storage::disk('local')
                    ->delete($newEvidencePath);
            }

            throw $exception;
        }


        return redirect()
            ->route('profile.author-verification')
            ->with(
                'verification_success',
                'Pengajuan verifikasi penulis berhasil dikirim dan sekarang menunggu pemeriksaan admin.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALISE ORCID
    |--------------------------------------------------------------------------
    */

    private function normaliseOrcid(
        ?string $orcid
    ): ?string {

        $orcid = trim((string) $orcid);

        if ($orcid === '') {
            return null;
        }

        $orcid = preg_replace(
            '#^https?://(?:www\.)?orcid\.org/#i',
            '',
            $orcid
        );

        return 'https://orcid.org/' . $orcid;
    }
}