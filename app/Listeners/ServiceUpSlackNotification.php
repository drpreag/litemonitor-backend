<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\ServiceUpEvent;
use App\Notifications\ServiceUpSlackNotify;

class ServiceUpSlackNotification
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
        Log::info("ServiceUpSlackNotification listener fired for service " . $event->service->name);
        $event->service->notify(new ServiceUpSlackNotify);
    }
}
