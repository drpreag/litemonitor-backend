<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\ServiceDownEvent;
use App\Notifications\ServiceDownSlackNotify;

class ServiceDownSlackNotification 
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
     * @param  ServiceDownEvent $event
     * @return void
     */
    public function handle(ServiceDownEvent $event)
    {
        Log::info("ServiceDownSlackNotification listener fired for service " . $event->service->name);
        $event->service->notify(new ServiceDownSlackNotify);
    }
}
