<?php

namespace App\Console\Commands;

use App\Site;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SiteCreate extends Command
{
    protected $signature   = 'site:create';
    protected $description = 'create a new sites';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        echo "SiteCreate job starts...\n";

        $sites = Site::where('status', 'pending')->get();

        foreach ($sites as $site) {
            $site->status = 'active';
            $site->save();

            printf("Activating site: [ %s ]\n", $site->name);
            event(new \App\Events\SiteUpdated($site));
        }

        echo "SiteCreate job ends...\n";
    }

}
