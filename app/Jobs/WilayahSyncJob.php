<?php

namespace App\Jobs;

use App\Services\WilayahSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class WilayahSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 1200;

    public string $statusKey;
    public string $cancelKey;
    public string $historyKey;
    public ?string $provinsiApiId;
    public string $depth;

    public function __construct(?string $provinsiApiId, string $depth, string $statusKey, string $cancelKey, string $historyKey)
    {
        $this->provinsiApiId = $provinsiApiId;
        $this->depth = $depth;
        $this->statusKey = $statusKey;
        $this->cancelKey = $cancelKey;
        $this->historyKey = $historyKey;
    }

    public function handle(WilayahSyncService $service): void
    {
        Cache::forget($this->cancelKey);
        $this->updateStatus([
            'status' => 'running',
            'message' => 'Sync sedang berjalan.',
            'started_at' => now()->toDateTimeString(),
            'percent' => 0,
        ]);

        try {
            $stats = $service->sync(
                $this->provinsiApiId,
                $this->depth,
                function (array $payload) {
                    $this->updateStatus(array_merge([
                        'status' => 'running',
                        'message' => $payload['message'] ?? 'Sync sedang berjalan.',
                    ], $payload));
                },
                function () {
                    return (bool) Cache::get($this->cancelKey, false);
                }
            );
            $this->updateStatus([
                'status' => 'success',
                'message' => 'Sync selesai.',
                'stats' => $stats,
                'percent' => 100,
                'finished_at' => now()->toDateTimeString(),
            ]);
            $this->pushHistory('success', $stats);
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'SYNC_CANCELLED') {
                $this->updateStatus([
                    'status' => 'cancelled',
                    'message' => 'Sync dibatalkan.',
                    'finished_at' => now()->toDateTimeString(),
                ]);
                $this->pushHistory('cancelled', null);
                return;
            }
            throw $e;
        } catch (\Throwable $e) {
            report($e);
            $this->updateStatus([
                'status' => 'error',
                'message' => 'Sync gagal. Silakan cek koneksi atau API.',
                'finished_at' => now()->toDateTimeString(),
            ]);
            $this->pushHistory('error', null);
            throw $e;
        }
    }

    private function updateStatus(array $payload): void
    {
        $current = Cache::get($this->statusKey, []);
        Cache::put($this->statusKey, array_merge($current, $payload), 86400);
    }

    private function pushHistory(string $status, ?array $stats): void
    {
        $history = Cache::get($this->historyKey, []);
        $history[] = [
            'status' => $status,
            'depth' => $this->depth,
            'provinsi_api_id' => $this->provinsiApiId,
            'stats' => $stats,
            'finished_at' => now()->toDateTimeString(),
        ];
        if (count($history) > 10) {
            $history = array_slice($history, -10);
        }
        Cache::put($this->historyKey, $history, 86400);
    }
}
