<?php

namespace App\Listeners;

use App\User;
use App\Events\ServiceUpEvent;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceEmailNotification;

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
        
        $users=User::where('active',1)->where('role_id', '>=',8)->get();
        foreach ($users as $user)
            Mail::to($user)->send(new ServiceEmailNotification($event->service));
    }
}
