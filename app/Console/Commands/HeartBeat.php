<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HeartBeat extends Command
{
    protected $signature   = 'heartbeat:check';
    protected $description = 'Laravel queue heartbeat check';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $message = sprintf('%s %s (%s): Laravel queue HeartBeat check...',
            date(DATE_ATOM), env('APP_NAME'), env('APP_ENV'));

        $this->info($message);
    }
}
