<?php

namespace App\Jobs;

use App\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SiteCreate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 360;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "SiteCreate job starts...\n";

        $sites = Site::where('status', 'pending')->get();

        foreach ($sites as $site) {
            $site->status = 'active';
            $site->save();

            printf("Activating site: [ %s ]\n", $site->name);
        }

        echo "SiteCreate job ends...\n";
    }

    /**
     * Get the tags that should be assigned to the job.
     * https://laravel.com/docs/5.6/horizon#tags
     *
     * @return array
     */
    public function tags()
    {
        return ['SiteCreate'];
    }
}
