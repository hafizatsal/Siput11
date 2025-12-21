<?php

namespace App\Console\Commands;

use App\Services\WilayahSyncService;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class WilayahDupeCheck extends Command
{
    protected $signature = 'wilayah:dupe-check
        {--depth=desa : provinsi|kabupaten|kecamatan|desa}
        {--provinsi= : ID provinsi (pisahkan dengan koma)}
        {--limit=20 : Jumlah contoh yang ditampilkan}';

    protected $description = 'Cek kemungkinan duplikasi data wilayah akibat beda penulisan.';

    public function handle(WilayahSyncService $service): int
    {
        $depth = strtolower(trim((string) $this->option('depth')));
        $validDepths = ['provinsi', 'kabupaten', 'kecamatan', 'desa'];
        if (!in_array($depth, $validDepths, true)) {
            $this->error('Depth tidak valid. Gunakan: provinsi, kabupaten, kecamatan, desa.');
            return 1;
        }

        $limit = (int) ($this->option('limit') ?? 20);
        if ($limit < 0) {
            $limit = 0;
        }

        $provinsiIds = $this->parseIdList((string) $this->option('provinsi'));

        $provinsiById = $this->loadProvinsiMap($provinsiIds);

        if ($depth === 'provinsi') {
            $this->reportDuplicates('Provinsi', $this->checkProvinsiDupes($service, $provinsiById, $limit));
            return 0;
        }

        $kabupatenById = $this->loadKabupatenMap($provinsiIds);

        if ($depth === 'kabupaten') {
            $result = $this->checkKabupatenDupes($service, $provinsiById, $provinsiIds, $limit);
            $this->reportDuplicates('Kabupaten', $result);
            return 0;
        }

        $kecamatanById = $this->loadKecamatanMap(array_keys($kabupatenById));

        if ($depth === 'kecamatan') {
            $result = $this->checkKecamatanDupes($service, $provinsiById, $kabupatenById, $provinsiIds, $limit);
            $this->reportDuplicates('Kecamatan', $result);
            return 0;
        }

        $result = $this->checkDesaDupes($service, $provinsiById, $kabupatenById, $kecamatanById, $provinsiIds, $limit);
        $this->reportDuplicates('Desa', $result);
        return 0;
    }

    private function parseIdList(string $value): array
    {
        $value = trim($value);
        if ($value === '') {
            return [];
        }

        $ids = [];
        foreach (explode(',', $value) as $id) {
            $id = trim($id);
            if ($id !== '') {
                $ids[] = $id;
            }
        }

        return $ids;
    }

    private function loadProvinsiMap(array $provinsiIds): array
    {
        $query = DB::table('provinsi')->select('id_provinsi', 'nama_provinsi');
        if (!empty($provinsiIds)) {
            $query->whereIn('id_provinsi', $provinsiIds);
        }

        return $query->pluck('nama_provinsi', 'id_provinsi')->all();
    }

    private function loadKabupatenMap(array $provinsiIds): array
    {
        $query = DB::table('kabupaten')->select('id', 'id_provinsi', 'nama_kabupaten');
        if (!empty($provinsiIds)) {
            $query->whereIn('id_provinsi', $provinsiIds);
        }

        $map = [];
        foreach ($query->get() as $row) {
            $map[$row->id] = [
                'id' => $row->id,
                'id_provinsi' => $row->id_provinsi,
                'nama_kabupaten' => $row->nama_kabupaten,
            ];
        }

        return $map;
    }

    private function loadKecamatanMap(array $kabupatenIds): array
    {
        if (empty($kabupatenIds)) {
            return [];
        }

        $map = [];
        foreach (DB::table('kecamatan')
            ->select('id', 'id_kabupaten', 'nama_kecamatan')
            ->whereIn('id_kabupaten', $kabupatenIds)
            ->get() as $row) {
            $map[$row->id] = [
                'id' => $row->id,
                'id_kabupaten' => $row->id_kabupaten,
                'nama_kecamatan' => $row->nama_kecamatan,
            ];
        }

        return $map;
    }

    private function checkProvinsiDupes(WilayahSyncService $service, array $provinsiById, int $limit): array
    {
        $groups = [];
        foreach ($provinsiById as $name) {
            $key = $service->normalizeName($service->normalizeProvinceName($name));
            $groups[$key][] = $name;
        }

        return $this->summarizeGroups($groups, null, $limit);
    }

    private function checkKabupatenDupes(WilayahSyncService $service, array $provinsiById, array $provinsiIds, int $limit): array
    {
        $query = DB::table('kabupaten')
            ->select('id_provinsi', 'nama_kabupaten', 'id')
            ->orderBy('id_provinsi')
            ->orderBy('id');
        if (!empty($provinsiIds)) {
            $query->whereIn('id_provinsi', $provinsiIds);
        }

        $labelFn = function (int $parentId) use ($provinsiById): string {
            return $provinsiById[$parentId] ?? ('Provinsi#' . $parentId);
        };

        return $this->checkByParent(
            $query,
            'id_provinsi',
            'nama_kabupaten',
            function (string $name) use ($service): string {
                return $service->normalizeName($service->normalizeKabupatenName($name));
            },
            $labelFn,
            $limit
        );
    }

    private function checkKecamatanDupes(
        WilayahSyncService $service,
        array $provinsiById,
        array $kabupatenById,
        array $provinsiIds,
        int $limit
    ): array {
        $query = DB::table('kecamatan')
            ->select('id_kabupaten', 'nama_kecamatan', 'id')
            ->orderBy('id_kabupaten')
            ->orderBy('id');
        if (!empty($provinsiIds)) {
            $kabupatenIds = array_keys($kabupatenById);
            if (empty($kabupatenIds)) {
                return ['groups' => 0, 'rows' => 0, 'samples' => []];
            }
            $query->whereIn('id_kabupaten', $kabupatenIds);
        }

        $labelFn = function (int $parentId) use ($provinsiById, $kabupatenById): string {
            $kabupaten = $kabupatenById[$parentId] ?? null;
            if (!$kabupaten) {
                return 'Kabupaten#' . $parentId;
            }
            $provName = $provinsiById[$kabupaten['id_provinsi']] ?? ('Provinsi#' . $kabupaten['id_provinsi']);
            return $provName . ' > ' . $kabupaten['nama_kabupaten'];
        };

        return $this->checkByParent(
            $query,
            'id_kabupaten',
            'nama_kecamatan',
            function (string $name) use ($service): string {
                return $service->normalizeName($service->normalizeKecamatanName($name));
            },
            $labelFn,
            $limit
        );
    }

    private function checkDesaDupes(
        WilayahSyncService $service,
        array $provinsiById,
        array $kabupatenById,
        array $kecamatanById,
        array $provinsiIds,
        int $limit
    ): array {
        $query = DB::table('desa')
            ->select('id_kecamatan', 'nama_desa', 'id')
            ->orderBy('id_kecamatan')
            ->orderBy('id');
        if (!empty($provinsiIds)) {
            $kecamatanIds = array_keys($kecamatanById);
            if (empty($kecamatanIds)) {
                return ['groups' => 0, 'rows' => 0, 'samples' => []];
            }
            $query->whereIn('id_kecamatan', $kecamatanIds);
        }

        $labelFn = function (int $parentId) use ($provinsiById, $kabupatenById, $kecamatanById): string {
            $kecamatan = $kecamatanById[$parentId] ?? null;
            if (!$kecamatan) {
                return 'Kecamatan#' . $parentId;
            }
            $kabupaten = $kabupatenById[$kecamatan['id_kabupaten']] ?? null;
            if (!$kabupaten) {
                return $kecamatan['nama_kecamatan'];
            }
            $provName = $provinsiById[$kabupaten['id_provinsi']] ?? ('Provinsi#' . $kabupaten['id_provinsi']);
            return $provName . ' > ' . $kabupaten['nama_kabupaten'] . ' > ' . $kecamatan['nama_kecamatan'];
        };

        return $this->checkByParent(
            $query,
            'id_kecamatan',
            'nama_desa',
            function (string $name) use ($service): string {
                $name = str_replace('-', ' ', $name);
                $name = preg_replace('/\s+/', ' ', trim($name));
                return $service->normalizeName($name);
            },
            $labelFn,
            $limit
        );
    }

    private function checkByParent(
        Builder $query,
        string $parentField,
        string $nameField,
        callable $normalizeName,
        callable $labelForParent,
        int $limit
    ): array {
        $groups = 0;
        $rows = 0;
        $samples = [];
        $currentParent = null;
        $bucket = [];

        foreach ($query->cursor() as $row) {
            $parentId = (int) $row->{$parentField};
            if ($currentParent === null) {
                $currentParent = $parentId;
            }
            if ($parentId !== $currentParent) {
                $this->flushBucket($bucket, $labelForParent($currentParent), $limit, $groups, $rows, $samples);
                $bucket = [];
                $currentParent = $parentId;
            }

            $name = (string) $row->{$nameField};
            $key = $normalizeName($name);
            $bucket[$key][] = $name;
        }

        if ($currentParent !== null) {
            $this->flushBucket($bucket, $labelForParent($currentParent), $limit, $groups, $rows, $samples);
        }

        return ['groups' => $groups, 'rows' => $rows, 'samples' => $samples];
    }

    private function flushBucket(array $bucket, string $label, int $limit, int &$groups, int &$rows, array &$samples): void
    {
        foreach ($bucket as $names) {
            $count = count($names);
            if ($count <= 1) {
                continue;
            }
            $groups++;
            $rows += $count;
            if ($limit > 0 && count($samples) < $limit) {
                $unique = array_values(array_unique($names));
                if (count($unique) === 1) {
                    $samples[] = $label . ' > ' . $unique[0] . ' (x' . $count . ')';
                } else {
                    $samples[] = $label . ' > ' . implode(' | ', $unique);
                }
            }
        }
    }

    private function summarizeGroups(array $groups, ?string $labelPrefix, int $limit): array
    {
        $groupCount = 0;
        $rowCount = 0;
        $samples = [];

        foreach ($groups as $names) {
            $count = count($names);
            if ($count <= 1) {
                continue;
            }
            $groupCount++;
            $rowCount += $count;
            if ($limit > 0 && count($samples) < $limit) {
                $unique = array_values(array_unique($names));
                $label = $labelPrefix ? ($labelPrefix . ' > ') : '';
                if (count($unique) === 1) {
                    $samples[] = $label . $unique[0] . ' (x' . $count . ')';
                } else {
                    $samples[] = $label . implode(' | ', $unique);
                }
            }
        }

        return ['groups' => $groupCount, 'rows' => $rowCount, 'samples' => $samples];
    }

    private function reportDuplicates(string $title, array $result): void
    {
        $this->info('Duplikat ' . $title . ':');
        $this->line('  Grup duplikat: ' . $result['groups']);
        $this->line('  Total data terduplikat: ' . $result['rows']);

        if (!empty($result['samples'])) {
            $this->line('  Contoh:');
            foreach ($result['samples'] as $sample) {
                $this->line('    - ' . $sample);
            }
        }
    }
}
