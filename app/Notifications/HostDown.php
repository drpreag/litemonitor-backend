<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Host;
use Illuminate\Support\Facades\Log;

class HostDown extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {              
        $host = Host::findOrFail($notifiable->id);

        Log::info ("Server Down by ping " . $host->fqdn);

        return (new SlackMessage)
            ->error()
            ->content("$host->name is Down")        
            ->attachment(function ($attachment) use ($host) {
                $attachment->title($host->fqdn)
                ->content("Down by Ping")
                ->color('danger');
            });
    }
}
