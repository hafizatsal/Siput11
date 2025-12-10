<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class LogClear extends Command
{
    protected $signature = 'log:clear';
    protected $description = 'Clear Laravel log file';

    public function handle()
    {
        $file = storage_path('logs/laravel.log');

        if (file_exists($file)) {
            file_put_contents($file, '');
            $this->info('Laravel log cleared successfully.');
        } else {
            $this->info('Log file not found or already empty.');
        }

        return Command::SUCCESS;
    }
}
