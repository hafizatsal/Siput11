<?php

return [
    'api_base' => env('WILAYAH_API_BASE', 'https://wilayah.id/api'),
    'sync_enabled' => env('WILAYAH_SYNC_ENABLED', false),
    'sync_depth' => env('WILAYAH_SYNC_DEPTH', 'desa'),
];
