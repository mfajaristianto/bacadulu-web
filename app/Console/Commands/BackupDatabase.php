<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Throwable;

class BackupDatabase extends Command
{
    /**
     * Nama command.
     */
    protected $signature = 'backup:database';

    /**
     * Deskripsi command.
     */
    protected $description =
        'Membuat backup database Baca Dulu secara aman';

    public function handle(): int
    {
        $this->info(
            'Memulai backup database Baca Dulu...'
        );

        try {
            /*
            |--------------------------------------------------------------------------
            | Pastikan driver database didukung
            |--------------------------------------------------------------------------
            */

            $connection =
                config('database.default');

            $driver =
                config(
                    "database.connections.{$connection}.driver"
                );

            if (
                ! in_array(
                    $driver,
                    [
                        'mysql',
                        'mariadb',
                    ],
                    true
                )
            ) {
                $message =
                    "Backup database otomatis saat ini "
                    . "hanya mendukung MySQL/MariaDB. "
                    . "Driver aktif: {$driver}";

                $this->error($message);

                Log::error(
                    'Database backup gagal',
                    [
                        'reason' => $message,
                    ]
                );

                return self::FAILURE;
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil konfigurasi database
            |--------------------------------------------------------------------------
            */

            $databaseConfig =
                config(
                    "database.connections.{$connection}"
                );

            $host =
                $databaseConfig['host']
                ?? '127.0.0.1';

            $port =
                $databaseConfig['port']
                ?? '3306';

            $database =
                $databaseConfig['database']
                ?? null;

            $username =
                $databaseConfig['username']
                ?? null;

            $password =
                $databaseConfig['password']
                ?? '';

            if (
                empty($database)
                ||
                empty($username)
            ) {
                throw new \RuntimeException(
                    'Konfigurasi database belum lengkap.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Direktori backup
            |--------------------------------------------------------------------------
            */

            $backupDirectory =
                config('backup.directory')
                . DIRECTORY_SEPARATOR
                . 'database';

            if (
                ! File::exists(
                    $backupDirectory
                )
            ) {
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
                    ->format(
                        'Y-m-d_H-i-s'
                    );

            $safeDatabaseName =
                preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '_',
                    $database
                );

            $filename =
                $safeDatabaseName
                . '_'
                . $timestamp
                . '.sql.gz';

            $backupPath =
                $backupDirectory
                . DIRECTORY_SEPARATOR
                . $filename;

            /*
            |--------------------------------------------------------------------------
            | mysqldump executable
            |--------------------------------------------------------------------------
            */

            $mysqldump =
                config(
                    'backup.mysqldump_path'
                );

            if (
                PHP_OS_FAMILY === 'Windows'
                &&
                ! File::exists(
                    $mysqldump
                )
            ) {
                throw new \RuntimeException(
                    'mysqldump tidak ditemukan di: '
                    . $mysqldump
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Command mysqldump
            |--------------------------------------------------------------------------
            |
            | Password tidak dimasukkan sebagai argument command.
            | Kita kirim lewat environment MYSQL_PWD.
            |
            */

            $command = [
                $mysqldump,

                '--host=' . $host,
                '--port=' . $port,
                '--user=' . $username,

                '--single-transaction',
                '--quick',
                '--lock-tables=false',

                '--routines',
                '--triggers',
                '--events',

                '--default-character-set=utf8mb4',

                $database,
            ];

            $process =
                new Process(
                    $command,
                    base_path(),
                    [
                        'MYSQL_PWD' =>
                            (string) $password,
                    ]
                );

            /*
             * Maksimum 5 menit.
             */
            $process->setTimeout(300);

            $process->run();

            if (
                ! $process->isSuccessful()
            ) {
                $error =
                    trim(
                        $process
                            ->getErrorOutput()
                    );

                throw new \RuntimeException(
                    'mysqldump gagal: '
                    . (
                        $error
                        ?: 'Unknown error'
                    )
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Compress SQL menjadi GZIP
            |--------------------------------------------------------------------------
            */

            $sql =
                $process->getOutput();

            if (
                trim($sql) === ''
            ) {
                throw new \RuntimeException(
                    'Hasil database dump kosong.'
                );
            }

            $compressed =
                gzencode(
                    $sql,
                    9
                );

            if (
                $compressed === false
            ) {
                throw new \RuntimeException(
                    'Database dump gagal dikompresi.'
                );
            }

            File::put(
                $backupPath,
                $compressed
            );

            /*
            |--------------------------------------------------------------------------
            | Validasi hasil backup
            |--------------------------------------------------------------------------
            */

            if (
                ! File::exists(
                    $backupPath
                )
                ||
                File::size(
                    $backupPath
                ) <= 0
            ) {
                throw new \RuntimeException(
                    'File backup gagal dibuat.'
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
                'Database backup berhasil',
                [
                    'database' =>
                        $database,

                    'file' =>
                        $filename,

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
            | Terminal output
            |--------------------------------------------------------------------------
            */

            $size =
                $this->formatBytes(
                    File::size(
                        $backupPath
                    )
                );

            $this->newLine();

            $this->info(
                'Backup database berhasil.'
            );

            $this->line(
                'Database : '
                . $database
            );

            $this->line(
                'File     : '
                . $backupPath
            );

            $this->line(
                'Ukuran   : '
                . $size
            );

            $this->newLine();

            return self::SUCCESS;
        } catch (Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Gagal backup
            |--------------------------------------------------------------------------
            */

            Log::error(
                'Database backup gagal',
                [
                    'message' =>
                        $exception
                            ->getMessage(),

                    'exception' =>
                        get_class(
                            $exception
                        ),
                ]
            );

            $this->newLine();

            $this->error(
                'Backup database gagal.'
            );

            $this->line(
                $exception
                    ->getMessage()
            );

            $this->newLine();

            return self::FAILURE;
        }
    }

    /**
     * Hapus backup yang sudah terlalu lama.
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
                $file
                    ->getMTime()
                <
                $expirationTime
            ) {
                File::delete(
                    $file
                        ->getPathname()
                );
            }
        }
    }

    /**
     * Ubah ukuran byte menjadi format manusia.
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

        if (
            $bytes >= 1024
        ) {
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