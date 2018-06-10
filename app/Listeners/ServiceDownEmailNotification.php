<?php

namespace App\Listeners;

use App\Events\ServiceDownEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ServiceDownEmailNotification
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
     * @param  ServiceDownEvent  $event
     * @return void
     */
    public function handle(ServiceDownEvent $event)
    {
        Log::info("ServiceDownEmailNotification listener fired for service " . $event->service->name);
    }
}
