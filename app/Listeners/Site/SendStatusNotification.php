<?php

namespace App\Listeners\Site;

use App\Events\SiteUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SiteUpdated  $event
     * @return void
     */
    public function handle(SiteUpdated $event)
    {
        //
    }
}
