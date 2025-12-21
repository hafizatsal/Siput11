<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WilayahSyncService
{
    public function listProvinces(): array
    {
        return $this->fetchList('provinces.json');
    }

    public function sync(?string $provinsiApiId = null, string $depth = 'desa', ?callable $onProgress = null, ?callable $shouldCancel = null): array
    {
        $depth = $this->normalizeDepth($depth);

        $stats = [
            'provinsi' => ['inserted' => 0, 'skipped' => 0],
            'kabupaten' => ['inserted' => 0, 'skipped' => 0],
            'kecamatan' => ['inserted' => 0, 'skipped' => 0],
            'desa' => ['inserted' => 0, 'skipped' => 0],
        ];

        $provinces = $this->fetchList('provinces.json');
        if ($provinsiApiId !== null) {
            $provinces = array_values(array_filter($provinces, function ($province) use ($provinsiApiId) {
                return (string) $province['id'] === (string) $provinsiApiId;
            }));
        }

        $weights = $this->phaseWeights($depth);
        $phaseProgress = [
            'provinsi' => 0,
            'kabupaten' => 0,
            'kecamatan' => 0,
            'desa' => 0,
        ];

        $updateProgress = function (string $phase, float $percent, string $message = '') use (&$phaseProgress, $weights, $onProgress) {
            if ($onProgress === null) {
                return;
            }
            $phaseProgress[$phase] = max(0, min(100, $percent));
            $overall = 0;
            foreach ($weights as $key => $weight) {
                $overall += ($phaseProgress[$key] / 100) * $weight;
            }
            $onProgress([
                'phase' => $phase,
                'phase_percent' => round($phaseProgress[$phase]),
                'percent' => round($overall),
                'message' => $message,
            ]);
        };

        $shouldStop = function () use ($shouldCancel) {
            return $shouldCancel ? (bool) $shouldCancel() : false;
        };

        $provinsiMap = [];
        foreach (DB::table('provinsi')->get() as $row) {
            $provinsiMap[$this->normalizeName($row->nama_provinsi)] = $row;
        }

        $totalProvinces = max(1, count($provinces));
        $provinsiIndex = 0;
        $kabupatenListsByProv = [];
        $kabupatenTotalAll = 0;
        $kecamatanListsByKab = [];
        $desaListsByKec = [];
        $kecamatanTotalAll = 0;
        $desaTotalAll = 0;
        if ($depth !== 'provinsi') {
            foreach ($provinces as $province) {
                if ($shouldStop()) {
                    throw new \RuntimeException('SYNC_CANCELLED');
                }
                $list = $this->fetchList('regencies/' . $province['id'] . '.json');
                $kabupatenListsByProv[$province['id']] = $list;
                $kabupatenTotalAll += count($list);
            }
            $kabupatenTotalAll = max(1, $kabupatenTotalAll);
        }
        $prefetchDeep = $provinsiApiId !== null && in_array($depth, ['kecamatan', 'desa'], true);
        if ($prefetchDeep) {
            foreach ($kabupatenListsByProv as $kabupatenList) {
                foreach ($kabupatenList as $kabupaten) {
                    if ($shouldStop()) {
                        throw new \RuntimeException('SYNC_CANCELLED');
                    }
                    $kecamatanList = $this->fetchList('districts/' . $kabupaten['id'] . '.json');
                    $kecamatanListsByKab[$kabupaten['id']] = $kecamatanList;
                    $kecamatanTotalAll += count($kecamatanList);
                    if ($depth === 'desa') {
                        foreach ($kecamatanList as $kecamatan) {
                            if ($shouldStop()) {
                                throw new \RuntimeException('SYNC_CANCELLED');
                            }
                            $desaList = $this->fetchList('villages/' . $kecamatan['id'] . '.json');
                            $desaListsByKec[$kecamatan['id']] = $desaList;
                            $desaTotalAll += count($desaList);
                        }
                    }
                }
            }
            $kecamatanTotalAll = max(1, $kecamatanTotalAll);
            if ($depth === 'desa') {
                $desaTotalAll = max(1, $desaTotalAll);
            }
        }

        $kabupatenProcessedAll = 0;
        $kecamatanProcessedAll = 0;
        $desaProcessedAll = 0;
        foreach ($provinces as $province) {
            if ($shouldStop()) {
                throw new \RuntimeException('SYNC_CANCELLED');
            }

            $provinsiName = $this->normalizeProvinceName($province['name']);
            $provinsiKey = $this->normalizeName($provinsiName);
            $provinsiRow = $provinsiMap[$provinsiKey] ?? null;
            if ($provinsiRow) {
                $provinsiId = $provinsiRow->id_provinsi;
                $stats['provinsi']['skipped']++;
            } else {
                $provinsiId = DB::table('provinsi')->insertGetId(
                    ['nama_provinsi' => $provinsiName],
                    'id_provinsi'
                );
                $provinsiMap[$provinsiKey] = (object) [
                    'id_provinsi' => $provinsiId,
                    'nama_provinsi' => $provinsiName,
                ];
                $stats['provinsi']['inserted']++;
            }

            $provinsiIndex++;
            $updateProgress('provinsi', ($provinsiIndex / $totalProvinces) * 100, 'Memproses provinsi.');

            if ($depth === 'provinsi') {
                continue;
            }

            $kabupatenList = $kabupatenListsByProv[$province['id']] ?? [];
            $kabupatenMap = DB::table('kabupaten')
                ->where('id_provinsi', $provinsiId)
                ->pluck('id', 'nama_kabupaten')
                ->all();
            $kabupatenMapNormalized = [];
            foreach ($kabupatenMap as $name => $id) {
                $kabName = $this->normalizeKabupatenName($name);
                $kabupatenMapNormalized[$this->normalizeName($kabName)] = $id;
            }

            $kabupatenIndex = 0;
            foreach ($kabupatenList as $kabupaten) {
                if ($shouldStop()) {
                    throw new \RuntimeException('SYNC_CANCELLED');
                }
                $kabupatenName = $this->normalizeKabupatenName($kabupaten['name']);
                $kabupatenKey = $this->normalizeName($kabupatenName);
                if (isset($kabupatenMapNormalized[$kabupatenKey])) {
                    $kabupatenId = $kabupatenMapNormalized[$kabupatenKey];
                    $stats['kabupaten']['skipped']++;
                } else {
                    $kabupatenId = DB::table('kabupaten')->insertGetId([
                        'id_provinsi' => $provinsiId,
                        'nama_kabupaten' => $kabupatenName,
                    ]);
                    $kabupatenMapNormalized[$kabupatenKey] = $kabupatenId;
                    $stats['kabupaten']['inserted']++;
                }

                $kabupatenIndex++;
                $kabupatenProcessedAll++;
                $updateProgress('kabupaten', ($kabupatenProcessedAll / $kabupatenTotalAll) * 100, 'Memproses kabupaten.');

                if ($depth === 'kabupaten') {
                    continue;
                }

                $kecamatanList = $kecamatanListsByKab[$kabupaten['id']] ?? $this->fetchList('districts/' . $kabupaten['id'] . '.json');
                $kecamatanMap = DB::table('kecamatan')
                    ->where('id_kabupaten', $kabupatenId)
                    ->pluck('id', 'nama_kecamatan')
                    ->all();
                $kecamatanMapNormalized = [];
                foreach ($kecamatanMap as $name => $id) {
                    $kecName = $this->normalizeKecamatanName($name);
                    $kecamatanMapNormalized[$this->normalizeName($kecName)] = $id;
                }

                foreach ($kecamatanList as $kecamatan) {
                    if ($shouldStop()) {
                        throw new \RuntimeException('SYNC_CANCELLED');
                    }
                    $kecamatanName = $this->normalizeKecamatanName($kecamatan['name']);
                    $kecamatanKey = $this->normalizeName($kecamatanName);
                    if (isset($kecamatanMapNormalized[$kecamatanKey])) {
                        $kecamatanId = $kecamatanMapNormalized[$kecamatanKey];
                        $stats['kecamatan']['skipped']++;
                    } else {
                        $kecamatanId = DB::table('kecamatan')->insertGetId([
                            'id_kabupaten' => $kabupatenId,
                            'nama_kecamatan' => $kecamatanName,
                        ]);
                        $kecamatanMapNormalized[$kecamatanKey] = $kecamatanId;
                        $stats['kecamatan']['inserted']++;
                    }

                    $kecamatanProcessedAll++;
                    if ($kecamatanTotalAll > 0) {
                        $updateProgress('kecamatan', ($kecamatanProcessedAll / $kecamatanTotalAll) * 100, 'Memproses kecamatan.');
                    }

                    if ($depth === 'kecamatan') {
                        continue;
                    }

                    $desaList = $desaListsByKec[$kecamatan['id']] ?? $this->fetchList('villages/' . $kecamatan['id'] . '.json');
                    $desaMap = DB::table('desa')
                        ->where('id_kecamatan', $kecamatanId)
                        ->pluck('id', 'nama_desa')
                        ->all();
                    $desaMapNormalized = [];
                    foreach ($desaMap as $name => $id) {
                        $desaMapNormalized[$this->normalizeName($name)] = $id;
                    }

                    foreach ($desaList as $desa) {
                        if ($shouldStop()) {
                            throw new \RuntimeException('SYNC_CANCELLED');
                        }
                        $desaName = trim($desa['name']);
                        $desaKey = $this->normalizeName($desaName);
                        if (isset($desaMapNormalized[$desaKey])) {
                            $stats['desa']['skipped']++;
                        } else {
                            DB::table('desa')->insert([
                                'id_kecamatan' => $kecamatanId,
                                'nama_desa' => $desaName,
                            ]);
                            $desaMapNormalized[$desaKey] = true;
                            $stats['desa']['inserted']++;
                        }

                        $desaProcessedAll++;
                        if ($desaTotalAll > 0 && ($desaProcessedAll % 100 === 0 || $desaProcessedAll === $desaTotalAll)) {
                            $updateProgress('desa', ($desaProcessedAll / $desaTotalAll) * 100, 'Memproses desa.');
                        }
                    }
                }

                if ($depth === 'desa' && $desaTotalAll === 0) {
                    $updateProgress('desa', ($kabupatenProcessedAll / $kabupatenTotalAll) * 100, 'Memproses desa.');
                }
            }
        }

        return $stats;
    }

    public function apiList(string $path): array
    {
        return $this->fetchList($path);
    }

    private function fetchList(string $path): array
    {
        $base = rtrim(config('wilayah.api_base'), '/');
        $response = Http::timeout(30)
            ->retry(3, 200)
            ->acceptJson()
            ->get($base . '/' . ltrim($path, '/'));

        if (!$response->ok()) {
            throw new \RuntimeException('Gagal mengambil data dari API wilayah.');
        }

        $data = $response->json();
        return $this->normalizeList($data);
    }

    private function normalizeList($data): array
    {
        if (!is_array($data)) {
            return [];
        }

        $items = $data;
        if (array_key_exists('data', $data) && is_array($data['data'])) {
            $items = $data['data'];
        }

        $normalized = [];
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }
            $id = $item['id'] ?? $item['code'] ?? null;
            $name = $item['name'] ?? null;
            if ($id === null || $name === null) {
                continue;
            }
            $normalized[] = [
                'id' => (string) $id,
                'name' => (string) $name,
            ];
        }

        return $normalized;
    }

    public function normalizeName(string $name): string
    {
        $name = preg_replace('/\s+/', ' ', trim($name));
        return strtoupper($name ?? '');
    }

    public function normalizeProvinceName(string $name): string
    {
        $map = [
            'DAERAH ISTIMEWA YOGYAKARTA' => 'DI YOGYAKARTA',
        ];
        $key = $this->normalizeName($name);
        return $map[$key] ?? trim($name);
    }

    public function normalizeKabupatenName(string $name): string
    {
        $name = trim($name);
        $name = str_replace('-', ' ', $name);
        $name = preg_replace('/\bKab\s+/i', 'Kabupaten ', $name);
        $name = preg_replace('/\bKab\.\s*/i', 'Kabupaten ', $name);
        $name = preg_replace('/\bKota Administrasi\s+/i', 'Kota ', $name);
        $name = preg_replace('/\bKabupaten Administrasi\s+/i', 'Kabupaten ', $name);
        while (preg_match('/\b([A-Z])\s+(?=[A-Z]\b)/i', $name)) {
            $name = preg_replace('/\b([A-Z])\s+(?=[A-Z]\b)/i', '$1', $name);
        }
        $name = preg_replace('/\s+/', ' ', $name);

        $map = [
            'Kabupaten Batanghari' => 'Kabupaten Batang Hari',
            'Kabupaten Fak Fak' => 'Kabupaten Fakfak',
            'Kabupaten Kepulauan Tanimbar' => 'Kabupaten Maluku Tenggara Barat',
            'Kabupaten Kotabaru' => 'Kabupaten Kota Baru',
            'Kabupaten Mahakam Ulu' => 'Kabupaten Mahakam Hulu',
            'Kabupaten Pasangkayu' => 'Kabupaten Mamuju Utara',
            'Kabupaten Tulang Bawang' => 'Kabupaten Tulangbawang',
            'Kabupaten Tulangbawang' => 'Kabupaten Tulangbawang',
            'Kota Banjarbaru' => 'Kota Banjar Baru',
            'Kota Bau Bau' => 'Kota Baubau',
            'Kota Palangkaraya' => 'Kota Palangka Raya',
            'Kota Lubuk Linggau' => 'Kota Lubuklinggau',
            'Kota Sawahlunto' => 'Kota Sawah Lunto',
            'Kabupaten Banyuasin' => 'Kabupaten Banyu Asin',
            'Kabupaten Labuhanbatu' => 'Kabupaten Labuhan Batu',
            'Kabupaten Kepulauan Siau Tagulandang Biaro' => 'Kabupaten Siau Tagulandang Biaro',
            'Kabupaten Kep. Siau Tagulandang Biaro' => 'Kabupaten Siau Tagulandang Biaro',
            'Kabupaten Labuhanbatu Selatan' => 'Kabupaten Labuhan Batu Selatan',
            'Kabupaten Labuhanbatu Utara' => 'Kabupaten Labuhan Batu Utara',
            'Kabupaten Ogan Komering' => 'Kabupaten Ogan Komering Ilir',
            'Kabupaten Toba' => 'Kabupaten Toba Samosir',
            'Kota Pematangsiantar' => 'Kota Pematang Siantar',
            'Kota Tanjungbalai' => 'Kota Tanjung Balai',
        ];
        return $map[$name] ?? $name;
    }

    public function normalizeKecamatanName(string $name): string
    {
        $name = trim($name);
        $name = str_replace('-', ' ', $name);
        while (preg_match('/\b([A-Z])\s+(?=[A-Z]\b)/i', $name)) {
            $name = preg_replace('/\b([A-Z])\s+(?=[A-Z]\b)/i', '$1', $name);
        }
        $name = preg_replace('/\s+/', ' ', $name);

        $map = [
            'Kalideres' => 'Kali Deres',
            'Kramatjati' => 'Kramat Jati',
            'Pal Merah' => 'Palmerah',
            'Pulogadung' => 'Pulo Gadung',
            'Setiabudi' => 'Setia Budi',
            'Botupingge' => 'Botu Pingge',
            'Talaga Jaya' => 'Telaga Jaya',
            'Batin II Babeko' => 'Bathin II Babeko',
            'Pasar Muaro Bungo' => 'Pasar Muara Bungo',
            'Depati Tujuh' => 'Depati VII',
            'Pondok Tinggi' => 'Pondok Tingggi',
        ];

        return $map[$name] ?? $name;
    }

    private function phaseWeights(string $depth): array
    {
        if ($depth === 'provinsi') {
            return ['provinsi' => 100, 'kabupaten' => 0, 'kecamatan' => 0, 'desa' => 0];
        }
        if ($depth === 'kabupaten') {
            return ['provinsi' => 40, 'kabupaten' => 60, 'kecamatan' => 0, 'desa' => 0];
        }
        if ($depth === 'kecamatan') {
            return ['provinsi' => 20, 'kabupaten' => 30, 'kecamatan' => 50, 'desa' => 0];
        }
        return ['provinsi' => 10, 'kabupaten' => 20, 'kecamatan' => 30, 'desa' => 40];
    }

    private function normalizeDepth(string $depth): string
    {
        $depth = strtolower(trim($depth));
        $valid = ['provinsi', 'kabupaten', 'kecamatan', 'desa'];
        return in_array($depth, $valid, true) ? $depth : 'desa';
    }
}
