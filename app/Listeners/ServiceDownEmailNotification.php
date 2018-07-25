<?php

namespace App\Listeners;

use App\Events\ServiceDownEvent;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Mail\ServiceEmailNotification;
use Illuminate\Support\Facades\Mail;
use App\User;

class ServiceDownEmailNotification
{
    protected $service;
    
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

        $users=User::where('active',1)->where('role_id','>=',8)->get();
        foreach ($users as $user) 
            Mail::to($user)->send(new ServiceEmailNotification($event->service));
    }
}
