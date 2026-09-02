<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;
use ZipArchive;

class BackupFiles extends Command
{
    /**
     * Nama command.
     */
    protected $signature = 'backup:files';

    /**
     * Deskripsi command.
     */
    protected $description =
        'Membuat backup file upload Baca Dulu';

    public function handle(): int
    {
        $this->info(
            'Memulai backup file Baca Dulu...'
        );

        try {
            /*
            |--------------------------------------------------------------------------
            | Pastikan ZipArchive tersedia
            |--------------------------------------------------------------------------
            */

            if (! class_exists(ZipArchive::class)) {
                throw new \RuntimeException(
                    'PHP ZipArchive belum aktif. '
                    . 'Aktifkan extension zip terlebih dahulu.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Direktori tujuan backup
            |--------------------------------------------------------------------------
            */

            $backupDirectory =
                config('backup.directory')
                . DIRECTORY_SEPARATOR
                . 'files';

            if (! File::exists($backupDirectory)) {
                File::makeDirectory(
                    $backupDirectory,
                    0755,
                    true
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Nama file
            |--------------------------------------------------------------------------
            */

            $timestamp =
                now()
                    ->timezone('Asia/Jakarta')
                    ->format('Y-m-d_H-i-s');

            $filename =
                'bacadulu_files_'
                . $timestamp
                . '.zip';

            $backupPath =
                $backupDirectory
                . DIRECTORY_SEPARATOR
                . $filename;

            /*
            |--------------------------------------------------------------------------
            | Buat ZIP
            |--------------------------------------------------------------------------
            */

            $zip =
                new ZipArchive();

            $result =
                $zip->open(
                    $backupPath,
                    ZipArchive::CREATE
                    | ZipArchive::OVERWRITE
                );

            if ($result !== true) {
                throw new \RuntimeException(
                    'File ZIP backup tidak dapat dibuat. '
                    . 'Kode error: '
                    . $result
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil sumber backup
            |--------------------------------------------------------------------------
            */

            $sources =
                config(
                    'backup.file_sources',
                    []
                );

            $addedFiles = 0;
            $processedSources = 0;

            foreach ($sources as $source) {
                /*
                 * Folder belum ada?
                 * Lewati, bukan dianggap error.
                 */
                if (! File::exists($source)) {
                    $this->warn(
                        'Folder dilewati karena tidak ditemukan: '
                        . $source
                    );

                    continue;
                }

                if (! File::isDirectory($source)) {
                    $this->warn(
                        'Path bukan direktori dan dilewati: '
                        . $source
                    );

                    continue;
                }

                $processedSources++;

                /*
                 * Nama root di dalam ZIP.
                 */
                $archiveRoot =
                    $this->makeArchiveRoot(
                        $source
                    );

                /*
                 * Tambahkan root folder.
                 */
                $zip->addEmptyDir(
                    $archiveRoot
                );

                /*
                 * Baca seluruh file secara rekursif.
                 */
                $iterator =
                    new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator(
                            $source,
                            RecursiveDirectoryIterator::SKIP_DOTS
                        ),
                        RecursiveIteratorIterator::SELF_FIRST
                    );

                foreach ($iterator as $item) {
                    $realPath =
                        $item->getPathname();

                    /*
                     * Hindari symbolic link.
                     *
                     * Ini penting supaya tidak terjadi loop
                     * atau backup folder yang sama dua kali.
                     */
                    if ($item->isLink()) {
                        continue;
                    }

                    $relativePath =
                        substr(
                            $realPath,
                            strlen($source) + 1
                        );

                    $relativePath =
                        str_replace(
                            '\\',
                            '/',
                            $relativePath
                        );

                    $archivePath =
                        $archiveRoot
                        . '/'
                        . $relativePath;

                    if ($item->isDir()) {
                        $zip->addEmptyDir(
                            $archivePath
                        );

                        continue;
                    }

                    if ($item->isFile()) {
                        $added =
                            $zip->addFile(
                                $realPath,
                                $archivePath
                            );

                        if (! $added) {
                            throw new \RuntimeException(
                                'Gagal memasukkan file ke backup: '
                                . $realPath
                            );
                        }

                        $addedFiles++;
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Tidak ada sumber yang valid
            |--------------------------------------------------------------------------
            */

            if ($processedSources === 0) {
                $zip->close();

                if (File::exists($backupPath)) {
                    File::delete(
                        $backupPath
                    );
                }

                throw new \RuntimeException(
                    'Tidak ada direktori upload yang dapat dibackup.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Tutup ZIP
            |--------------------------------------------------------------------------
            */

            if (! $zip->close()) {
                throw new \RuntimeException(
                    'File ZIP gagal diselesaikan.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Validasi hasil
            |--------------------------------------------------------------------------
            */

            if (
                ! File::exists($backupPath)
                ||
                File::size($backupPath) <= 0
            ) {
                throw new \RuntimeException(
                    'File backup ZIP tidak berhasil dibuat.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Bersihkan backup lama
            |--------------------------------------------------------------------------
            */

            $this->cleanupOldBackups(
                $backupDirectory
            );

            /*
            |--------------------------------------------------------------------------
            | Logging
            |--------------------------------------------------------------------------
            */

            Log::info(
                'File backup berhasil',
                [
                    'file' =>
                        $filename,

                    'file_count' =>
                        $addedFiles,

                    'source_count' =>
                        $processedSources,

                    'size' =>
                        File::size(
                            $backupPath
                        ),

                    'created_at' =>
                        now()
                            ->timezone(
                                'Asia/Jakarta'
                            )
                            ->toDateTimeString(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Output terminal
            |--------------------------------------------------------------------------
            */

            $this->newLine();

            $this->info(
                'Backup file berhasil.'
            );

            $this->line(
                'File       : '
                . $backupPath
            );

            $this->line(
                'Sumber     : '
                . $processedSources
                . ' folder'
            );

            $this->line(
                'Total file : '
                . $addedFiles
            );

            $this->line(
                'Ukuran     : '
                . $this->formatBytes(
                    File::size(
                        $backupPath
                    )
                )
            );

            $this->newLine();

            return self::SUCCESS;
        } catch (Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Logging gagal
            |--------------------------------------------------------------------------
            */

            Log::error(
                'File backup gagal',
                [
                    'message' =>
                        $exception->getMessage(),

                    'exception' =>
                        get_class(
                            $exception
                        ),
                ]
            );

            $this->newLine();

            $this->error(
                'Backup file gagal.'
            );

            $this->line(
                $exception->getMessage()
            );

            $this->newLine();

            return self::FAILURE;
        }
    }

    /**
     * Tentukan nama folder di dalam ZIP.
     */
    private function makeArchiveRoot(
        string $source
    ): string {
        $normalized =
            str_replace(
                '\\',
                '/',
                $source
            );

        $storagePublic =
            str_replace(
                '\\',
                '/',
                storage_path(
                    'app/public'
                )
            );

        if ($normalized === $storagePublic) {
            return 'storage-app-public';
        }

        /*
         * Untuk folder public langsung,
         * misalnya public/book-covers.
         */
        if (
            str_starts_with(
                $normalized,
                str_replace(
                    '\\',
                    '/',
                    public_path()
                )
            )
        ) {
            return 'public-'
                . basename(
                    $normalized
                );
        }

        return 'uploads-'
            . basename(
                $normalized
            );
    }

    /**
     * Hapus backup file yang sudah terlalu lama.
     */
    private function cleanupOldBackups(
        string $directory
    ): void {
        $retentionDays =
            max(
                1,
                (int) config(
                    'backup.retention_days',
                    14
                )
            );

        $expirationTime =
            now()
                ->subDays(
                    $retentionDays
                )
                ->timestamp;

        foreach (
            File::files(
                $directory
            )
            as $file
        ) {
            if (
                $file->getExtension()
                !== 'zip'
            ) {
                continue;
            }

            if (
                $file->getMTime()
                <
                $expirationTime
            ) {
                File::delete(
                    $file->getPathname()
                );
            }
        }
    }

    /**
     * Format ukuran file.
     */
    private function formatBytes(
        int $bytes
    ): string {
        if (
            $bytes >=
            1024 * 1024 * 1024
        ) {
            return round(
                $bytes /
                (
                    1024 *
                    1024 *
                    1024
                ),
                2
            )
            . ' GB';
        }

        if (
            $bytes >=
            1024 * 1024
        ) {
            return round(
                $bytes /
                (
                    1024 *
                    1024
                ),
                2
            )
            . ' MB';
        }

        if ($bytes >= 1024) {
            return round(
                $bytes / 1024,
                2
            )
            . ' KB';
        }

        return $bytes
            . ' bytes';
    }
}