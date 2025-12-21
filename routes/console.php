<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::command('log:clear')->weekly();
if (config('wilayah.sync_enabled')) {
    Schedule::command('wilayah:sync --depth=' . config('wilayah.sync_depth'))->dailyAt('02:00');
}

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
