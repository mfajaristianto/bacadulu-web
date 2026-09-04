<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'photo.required' => 'Pilih foto terlebih dahulu.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WebP.',
            'photo.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $user = $request->user();
        $oldPhoto = $user->profile_photo;

        $newPhoto = $this->processProfilePhoto(
            $request->file('photo')
        );

        $user->profile_photo = $newPhoto;
        $user->avatar_source = 'custom';
        $user->save();

        if (
            $oldPhoto &&
            $oldPhoto !== $newPhoto
        ) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return back()->with(
            'profile_success',
            'Foto profil berhasil diperbarui.'
        );
    }

    public function useGoogle(Request $request)
    {
        $user = $request->user();

        if (
            !$user->avatar ||
            !filter_var(
                $user->avatar,
                FILTER_VALIDATE_URL
            )
        ) {
            return back()->withErrors([
                'avatar' => 'Foto dari akun Google tidak tersedia.',
            ]);
        }

        $user->avatar_source = 'google';
        $user->save();

        return back()->with(
            'profile_success',
            'Foto Google berhasil digunakan.'
        );
    }

    public function useInitials(Request $request)
    {
        $user = $request->user();

        $user->avatar_source = 'initials';
        $user->save();

        return back()->with(
            'profile_success',
            'Foto profil diganti menjadi inisial nama.'
        );
    }

    public function googleAvatar(User $user)
    {
        $url = trim((string) $user->avatar);

        if (
            !$url ||
            !filter_var(
                $url,
                FILTER_VALIDATE_URL
            )
        ) {
            abort(404);
        }

        $host = strtolower(
            (string) parse_url(
                $url,
                PHP_URL_HOST
            )
        );

        $allowed =
            $host === 'googleusercontent.com' ||
            str_ends_with(
                $host,
                '.googleusercontent.com'
            );

        if (!$allowed) {
            abort(404);
        }

        $googleUrl = preg_replace(
            '/=s\d+-c$/',
            '=s256-c',
            $url
        );

        $hash = sha1($googleUrl);

        $relativePath =
            'google-avatars/' .
            $user->id .
            '-' .
            $hash .
            '.jpg';

        $disk = Storage::disk('public');

        if (!$disk->exists($relativePath)) {
            try {
                $response = Http::timeout(6)
                    ->connectTimeout(4)
                    ->retry(1, 150)
                    ->get($googleUrl);

                if (!$response->successful()) {
                    abort(404);
                }

                $contentType = strtolower(
                    (string) $response->header(
                        'Content-Type'
                    )
                );

                if (!str_starts_with(
                    $contentType,
                    'image/'
                )) {
                    abort(404);
                }

                $body = $response->body();

                if ($body === '') {
                    abort(404);
                }

                if (!$disk->put(
                    $relativePath,
                    $body
                )) {
                    abort(404);
                }
            } catch (Throwable $exception) {
                report($exception);

                abort(404);
            }
        }

        $path = $disk->path($relativePath);

        if (!is_file($path)) {
            abort(404);
        }

        return response()->file(
            $path,
            [
                'Cache-Control' =>
                    'public, max-age=604800, immutable',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PROCESS CUSTOM PROFILE PHOTO
    |--------------------------------------------------------------------------
    |
    | - Fix orientation foto dari HP
    | - Center crop menjadi kotak
    | - Resize menjadi 512 x 512
    | - Tidak membuat foto gepeng
    | - Output WebP jika server mendukung
    |
    */

    private function processProfilePhoto(
        UploadedFile $file
    ): string {
        if (!extension_loaded('gd')) {
            throw ValidationException::withMessages([
                'photo' =>
                    'PHP GD belum aktif sehingga foto tidak dapat diproses.',
            ]);
        }

        $sourcePath = $file->getRealPath();

        if (
            !$sourcePath ||
            !is_file($sourcePath)
        ) {
            throw ValidationException::withMessages([
                'photo' =>
                    'Foto tidak dapat dibaca. Silakan upload ulang.',
            ]);
        }

        $info = @getimagesize($sourcePath);

        if (!$info) {
            throw ValidationException::withMessages([
                'photo' =>
                    'File foto tidak valid.',
            ]);
        }

        $binary = @file_get_contents(
            $sourcePath
        );

        if ($binary === false) {
            throw ValidationException::withMessages([
                'photo' =>
                    'Foto gagal dibaca.',
            ]);
        }

        $source = @imagecreatefromstring(
            $binary
        );

        if (!$source) {
            throw ValidationException::withMessages([
                'photo' =>
                    'Foto gagal diproses.',
            ]);
        }

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        /*
        |--------------------------------------------------------------------------
        | FIX ORIENTATION FOTO HP
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $extension,
                ['jpg', 'jpeg'],
                true
            )
        ) {
            $source = $this->fixJpegOrientation(
                $source,
                $sourcePath
            );
        }

        $width = imagesx($source);
        $height = imagesy($source);

        if (
            $width < 1 ||
            $height < 1
        ) {
            imagedestroy($source);

            throw ValidationException::withMessages([
                'photo' =>
                    'Resolusi foto tidak valid.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | CENTER CROP
        |--------------------------------------------------------------------------
        |
        | Portrait:
        |
        |       ┌────────┐
        |       │        │
        |       │  CROP  │
        |       │        │
        |       └────────┘
        |
        | Landscape juga otomatis dipotong dari tengah.
        |
        */

        $cropSize = min(
            $width,
            $height
        );

        $sourceX = max(
            0,
            (int) floor(
                ($width - $cropSize) / 2
            )
        );

        $sourceY = max(
            0,
            (int) floor(
                ($height - $cropSize) / 2
            )
        );

        $targetSize = 512;

        $destination = imagecreatetruecolor(
            $targetSize,
            $targetSize
        );

        if (!$destination) {
            imagedestroy($source);

            throw ValidationException::withMessages([
                'photo' =>
                    'Foto gagal diproses oleh server.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | BACKGROUND
        |--------------------------------------------------------------------------
        */

        $white = imagecolorallocate(
            $destination,
            255,
            255,
            255
        );

        imagefill(
            $destination,
            0,
            0,
            $white
        );

        $success = imagecopyresampled(
            $destination,
            $source,
            0,
            0,
            $sourceX,
            $sourceY,
            $targetSize,
            $targetSize,
            $cropSize,
            $cropSize
        );

        imagedestroy($source);

        if (!$success) {
            imagedestroy($destination);

            throw ValidationException::withMessages([
                'photo' =>
                    'Foto gagal dipotong.',
            ]);
        }

        $useWebp = function_exists(
            'imagewebp'
        );

        $extension = $useWebp
            ? 'webp'
            : 'jpg';

        $fileName =
            Str::uuid()->toString() .
            '.' .
            $extension;

        $relativePath =
            'profile-photos/' .
            $fileName;

        $temporaryPath = tempnam(
            sys_get_temp_dir(),
            'bacadulu-avatar-'
        );

        if ($temporaryPath === false) {
            imagedestroy($destination);

            throw ValidationException::withMessages([
                'photo' =>
                    'Server gagal membuat file sementara.',
            ]);
        }

        try {
            if ($useWebp) {
                $encoded = @imagewebp(
                    $destination,
                    $temporaryPath,
                    90
                );
            } else {
                imageinterlace(
                    $destination,
                    true
                );

                $encoded = @imagejpeg(
                    $destination,
                    $temporaryPath,
                    92
                );
            }

            if (!$encoded) {
                throw ValidationException::withMessages([
                    'photo' =>
                        'Foto gagal dikonversi.',
                ]);
            }

            $processed =
                @file_get_contents(
                    $temporaryPath
                );

            if ($processed === false) {
                throw ValidationException::withMessages([
                    'photo' =>
                        'Foto hasil proses gagal dibaca.',
                ]);
            }

            $stored =
                Storage::disk('public')
                    ->put(
                        $relativePath,
                        $processed
                    );

            if (!$stored) {
                throw ValidationException::withMessages([
                    'photo' =>
                        'Foto gagal disimpan.',
                ]);
            }
        } finally {
            imagedestroy($destination);

            if (
                is_file(
                    $temporaryPath
                )
            ) {
                @unlink(
                    $temporaryPath
                );
            }
        }

        return $relativePath;
    }

    /*
    |--------------------------------------------------------------------------
    | FIX EXIF ORIENTATION
    |--------------------------------------------------------------------------
    */

    private function fixJpegOrientation(
        $image,
        string $path
    ) {
        if (!function_exists(
            'exif_read_data'
        )) {
            return $image;
        }

        $exif = @exif_read_data(
            $path
        );

        if (!is_array($exif)) {
            return $image;
        }

        $orientation = (int) (
            $exif['Orientation']
            ?? 1
        );

        switch ($orientation) {
            case 2:
                if (function_exists('imageflip')) {
                    imageflip(
                        $image,
                        IMG_FLIP_HORIZONTAL
                    );
                }
                break;

            case 3:
                $image = $this->rotateImage(
                    $image,
                    180
                );
                break;

            case 4:
                if (function_exists('imageflip')) {
                    imageflip(
                        $image,
                        IMG_FLIP_VERTICAL
                    );
                }
                break;

            case 5:
                if (function_exists('imageflip')) {
                    imageflip(
                        $image,
                        IMG_FLIP_HORIZONTAL
                    );
                }

                $image = $this->rotateImage(
                    $image,
                    90
                );
                break;

            case 6:
                $image = $this->rotateImage(
                    $image,
                    -90
                );
                break;

            case 7:
                if (function_exists('imageflip')) {
                    imageflip(
                        $image,
                        IMG_FLIP_HORIZONTAL
                    );
                }

                $image = $this->rotateImage(
                    $image,
                    -90
                );
                break;

            case 8:
                $image = $this->rotateImage(
                    $image,
                    90
                );
                break;
        }

        return $image;
    }

    private function rotateImage(
        $image,
        float $angle
    ) {
        $rotated = @imagerotate(
            $image,
            $angle,
            0
        );

        if (!$rotated) {
            return $image;
        }

        imagedestroy($image);

        return $rotated;
    }
}