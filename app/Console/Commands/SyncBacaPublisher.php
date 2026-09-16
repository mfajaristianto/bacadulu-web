<?php

namespace App\Console\Commands;

use App\Services\BacaPublisher\BacaPublisherSyncService;
use Illuminate\Console\Command;
use Throwable;

class SyncBacaPublisher extends Command
{
    protected $signature = 'publisher:sync';

    protected $description = 'Sinkronkan buku Published dari Baca Dulu Publisher ke workflow pending BacaDulu.';

    public function handle(BacaPublisherSyncService $syncService): int
    {
        if (!$syncService->configured()) {
            $this->warn('BacaPublisher belum dikonfigurasi. Isi BACAPUBLISHER_API_URL dan BACAPUBLISHER_API_KEY di .env.');
            return self::FAILURE;
        }

        $this->info('Memulai sinkronisasi BacaPublisher...');

        try {
            $result = $syncService->sync();
        } catch (Throwable $e) {
            $this->error('Sync gagal: ' . $e->getMessage());
            report($e);
            return self::FAILURE;
        }

        $this->table(
            ['Diterima', 'Buku Baru', 'Tetap', 'Update Pending', 'Dilewati', 'Gagal'],
            [[
                $result['received'],
                $result['created'],
                $result['unchanged'],
                $result['pending_updates'],
                $result['skipped'],
                $result['failed'],
            ]]
        );

        foreach ($result['warnings'] as $warning) {
            $this->warn($warning);
        }

        foreach ($result['errors'] as $error) {
            $this->error($error);
        }

        return $result['failed'] > 0
            ? self::FAILURE
            : self::SUCCESS;
    }
}
