<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomServeCommand extends Command
{
    protected $signature = 'custom:serve {--port=9700}';
    protected $description = 'start server';

    public function handle()
    {
        $port = $this->option('port');
        $this->call('serve', [
            '--port' => $port,
        ]);
    }
}
