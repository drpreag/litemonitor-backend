<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ServiceDownEvent' => [
            'App\Listeners\ServiceDownPushNotification',
            'App\Listeners\ServiceDownEmailNotification',
            'App\Listeners\ServiceDownSlackNotification',
        ],
        'App\Events\ServiceUpEvent' => [
            'App\Listeners\ServiceUpPushNotification',
            'App\Listeners\ServiceUpEmailNotification',
            'App\Listeners\ServiceUpSlackNotification',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
