<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WilayahSyncService;

class WilayahSync extends Command
{
    protected $signature = 'wilayah:sync {--provinsi= : ID provinsi dari API} {--depth=desa : provinsi|kabupaten|kecamatan|desa}';
    protected $description = 'Sinkron data wilayah dari API publik.';

    public function handle(WilayahSyncService $service): int
    {
        $depth = $this->option('depth');
        $valid = ['provinsi', 'kabupaten', 'kecamatan', 'desa'];
        if (!in_array($depth, $valid, true)) {
            $this->error('Depth tidak valid. Gunakan: provinsi, kabupaten, kecamatan, desa.');
            return 1;
        }

        $provinsiId = $this->option('provinsi');

        $stats = $service->sync($provinsiId, $depth);

        $this->info('Sync selesai.');
        $this->line('Provinsi: ' . $stats['provinsi']['inserted'] . ' baru, ' . $stats['provinsi']['skipped'] . ' sudah ada.');
        $this->line('Kabupaten: ' . $stats['kabupaten']['inserted'] . ' baru, ' . $stats['kabupaten']['skipped'] . ' sudah ada.');
        $this->line('Kecamatan: ' . $stats['kecamatan']['inserted'] . ' baru, ' . $stats['kecamatan']['skipped'] . ' sudah ada.');
        $this->line('Desa: ' . $stats['desa']['inserted'] . ' baru, ' . $stats['desa']['skipped'] . ' sudah ada.');

        return 0;
    }
}
