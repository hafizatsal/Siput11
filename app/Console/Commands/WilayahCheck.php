<?php

namespace App\Console\Commands;

use App\Services\WilayahSyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WilayahCheck extends Command
{
    protected $signature = 'wilayah:check {--provinsi= : ID provinsi dari API (pisahkan dengan koma)} {--depth=kabupaten : provinsi|kabupaten|kecamatan|desa} {--limit=20 : Jumlah contoh yang ditampilkan} {--progress : Tampilkan progress}';
    protected $description = 'Cek perbedaan data wilayah API vs database (tanpa mengubah data).';

    public function handle(WilayahSyncService $service): int
    {
        $depth = $this->option('depth') ?? 'kabupaten';
        $validDepths = ['provinsi', 'kabupaten', 'kecamatan', 'desa'];
        if (!in_array($depth, $validDepths, true)) {
            $this->error('Depth tidak valid. Gunakan: provinsi, kabupaten, kecamatan, desa.');
            return 1;
        }

        $limit = (int) ($this->option('limit') ?? 20);
        if ($limit < 0) {
            $limit = 0;
        }

        $provinsiOption = trim((string) $this->option('provinsi'));
        $provinsiIds = [];
        if ($provinsiOption !== '') {
            foreach (explode(',', $provinsiOption) as $id) {
                $id = trim($id);
                if ($id !== '') {
                    $provinsiIds[] = $id;
                }
            }
        }

        $provinsiMap = [];
        foreach (DB::table('provinsi')->get() as $row) {
            $provinsiMap[$service->normalizeName($row->nama_provinsi)] = $row;
        }

        $apiProvinces = $service->apiList('provinces.json');
        if (!empty($provinsiIds)) {
            $provinsiLookup = array_flip(array_map('strval', $provinsiIds));
            $apiProvinces = array_values(array_filter($apiProvinces, function ($prov) use ($provinsiLookup) {
                return isset($provinsiLookup[(string) $prov['id']]);
            }));
        }

        if ($depth === 'desa' && empty($provinsiIds)) {
            $this->warn('Cek depth desa untuk semua provinsi bisa sangat lama. Gunakan --provinsi=ID untuk mempercepat.');
        }

        $showProgress = (bool) $this->option('progress');
        $progress = null;
        if ($showProgress && $depth !== 'provinsi' && !empty($apiProvinces)) {
            $this->line('Memproses provinsi...');
            $progress = $this->output->createProgressBar(count($apiProvinces));
            $progress->start();
        }

        $missingProvinsiCount = 0;
        $missingProvinsiSample = [];
        $aliasProvinsiCount = 0;
        $aliasProvinsiSample = [];

        foreach ($apiProvinces as $province) {
            $normalizedName = $service->normalizeProvinceName($province['name']);
            $key = $service->normalizeName($normalizedName);
            if (!isset($provinsiMap[$key])) {
                $missingProvinsiCount++;
                $this->recordSample($missingProvinsiSample, $normalizedName, $limit);
                continue;
            }
            $existing = $provinsiMap[$key]->nama_provinsi ?? '';
            if ($existing !== $normalizedName) {
                $aliasProvinsiCount++;
                $this->recordSample($aliasProvinsiSample, $existing . ' ~ ' . $normalizedName, $limit);
            }
        }

        $this->info('Cek provinsi:');
        $this->line('  Missing: ' . $missingProvinsiCount);
        $this->renderSample('  Contoh missing', $missingProvinsiSample);
        $this->line('  Alias beda penulisan: ' . $aliasProvinsiCount);
        $this->renderSample('  Contoh alias', $aliasProvinsiSample);

        if ($depth === 'provinsi') {
            if ($progress) {
                $progress->finish();
                $this->newLine(2);
            }
            return 0;
        }

        $missingKabupatenCount = 0;
        $missingKabupatenSample = [];
        $missingKecamatanCount = 0;
        $missingKecamatanSample = [];
        $missingDesaCount = 0;
        $missingDesaSample = [];

        foreach ($apiProvinces as $province) {
            $normalizedName = $service->normalizeProvinceName($province['name']);
            $provKey = $service->normalizeName($normalizedName);
            $provRow = $provinsiMap[$provKey] ?? null;
            if (!$provRow) {
                continue;
            }

            $kabupatenList = $service->apiList('regencies/' . $province['id'] . '.json');
            $kabupatenMap = DB::table('kabupaten')
                ->where('id_provinsi', $provRow->id_provinsi)
                ->pluck('id', 'nama_kabupaten')
                ->all();
            $kabupatenMapNormalized = [];
            foreach ($kabupatenMap as $name => $id) {
                $kabupatenMapNormalized[$service->normalizeName($service->normalizeKabupatenName($name))] = $id;
            }

            foreach ($kabupatenList as $kabupaten) {
                $kabName = $service->normalizeKabupatenName($kabupaten['name']);
                $kabKey = $service->normalizeName($kabName);
                if (!isset($kabupatenMapNormalized[$kabKey])) {
                    $missingKabupatenCount++;
                    $this->recordSample($missingKabupatenSample, $normalizedName . ' > ' . $kabName, $limit);
                }
            }

            if ($depth === 'kabupaten') {
                if ($progress) {
                    $progress->advance();
                }
                continue;
            }

            foreach ($kabupatenList as $kabupaten) {
                $kabName = $service->normalizeKabupatenName($kabupaten['name']);
                $kabKey = $service->normalizeName($kabName);
                $kabId = $kabupatenMapNormalized[$kabKey] ?? null;
                if (!$kabId) {
                    continue;
                }

                $kecamatanList = $service->apiList('districts/' . $kabupaten['id'] . '.json');
                $kecamatanMap = DB::table('kecamatan')
                    ->where('id_kabupaten', $kabId)
                    ->pluck('id', 'nama_kecamatan')
                    ->all();
                $kecamatanMapNormalized = [];
                foreach ($kecamatanMap as $name => $id) {
                    $kecamatanMapNormalized[$service->normalizeName($service->normalizeKecamatanName($name))] = $id;
                }

                foreach ($kecamatanList as $kecamatan) {
                    $kecName = $service->normalizeKecamatanName($kecamatan['name']);
                    $kecKey = $service->normalizeName($kecName);
                    if (!isset($kecamatanMapNormalized[$kecKey])) {
                        $missingKecamatanCount++;
                        $this->recordSample($missingKecamatanSample, $normalizedName . ' > ' . $kabName . ' > ' . $kecName, $limit);
                    }
                }

                if ($depth === 'kecamatan') {
                    continue;
                }

                foreach ($kecamatanList as $kecamatan) {
                    $kecName = trim($kecamatan['name']);
                    $kecKey = $service->normalizeName($kecName);
                    $kecId = $kecamatanMapNormalized[$kecKey] ?? null;
                    if (!$kecId) {
                        continue;
                    }

                    $desaList = $service->apiList('villages/' . $kecamatan['id'] . '.json');
                    $desaMap = DB::table('desa')
                        ->where('id_kecamatan', $kecId)
                        ->pluck('id', 'nama_desa')
                        ->all();
                    $desaMapNormalized = [];
                    foreach ($desaMap as $name => $id) {
                        $desaMapNormalized[$service->normalizeName($name)] = $id;
                    }

                    foreach ($desaList as $desa) {
                        $desaName = trim($desa['name']);
                        $desaKey = $service->normalizeName($desaName);
                        if (!isset($desaMapNormalized[$desaKey])) {
                            $missingDesaCount++;
                            $this->recordSample($missingDesaSample, $normalizedName . ' > ' . $kabName . ' > ' . $kecName . ' > ' . $desaName, $limit);
                        }
                    }
                }
            }

            if ($progress) {
                $progress->advance();
            }
        }

        if ($progress) {
            $progress->finish();
            $this->newLine(2);
        }

        $this->info('Cek kabupaten:');
        $this->line('  Missing: ' . $missingKabupatenCount);
        $this->renderSample('  Contoh missing', $missingKabupatenSample);

        if ($depth === 'kabupaten') {
            return 0;
        }

        $this->info('Cek kecamatan:');
        $this->line('  Missing: ' . $missingKecamatanCount);
        $this->renderSample('  Contoh missing', $missingKecamatanSample);

        if ($depth === 'kecamatan') {
            return 0;
        }

        $this->info('Cek desa:');
        $this->line('  Missing: ' . $missingDesaCount);
        $this->renderSample('  Contoh missing', $missingDesaSample);

        return 0;
    }

    private function renderSample(string $label, array $items): void
    {
        if (empty($items)) {
            return;
        }

        $this->line($label . ':');
        foreach ($items as $item) {
            $this->line('    - ' . $item);
        }
    }

    private function recordSample(array &$samples, string $item, int $limit): void
    {
        if ($limit <= 0) {
            return;
        }

        if (count($samples) >= $limit) {
            return;
        }

        $samples[] = $item;
    }
}
