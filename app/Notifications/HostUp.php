<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Host;
use Illuminate\Support\Facades\Log;

class HostUp extends Notification
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
        //dd ($notifiable);
        $host = Host::findOrFail($notifiable->id);

        Log::info ("Server Up by ping " . $host->fqdn);

        return (new SlackMessage)
            ->error()
            ->content("$host->name is Up")        
            ->attachment(function ($attachment) use ($host) {
                $attachment->title($host->fqdn)
                ->content("Up by Ping")
                ->color('good');
            });
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
