<?php

namespace App\Listeners;

use App\Events\ServiceUpEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ServiceUpEmailNotification
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
     * @param  ServiceUpEvent  $event
     * @return void
     */
    public function handle(ServiceUpEvent $event)
    {
        Log::info("ServiceUpEmailNotification listener fired for service " . $event->service->name);
    }
}
