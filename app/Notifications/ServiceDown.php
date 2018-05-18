<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use App\Host;
use App\Probe;
use App\Service;
use Illuminate\Support\Facades\Log;

class ServiceDown extends Notification
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
        $host = Host::findOrFail($notifiable->host_id);
        $probe = Probe::findOrFail($notifiable->probe_id);
        $port = $notifiable->port;
        $hostProbe = Service::findOrFail($notifiable['id']);

        Log::info ("Server $host->fqdn; Probe $hostProbe->name; Down by probe $probe->name:$port");

        return (new SlackMessage)
            ->error()
            ->content("$host->name is Down")
            ->attachment(function ($attachment) use ($host, $hostProbe, $probe, $port) {
                $attachment->title($host->fqdn)
                ->content("Service $hostProbe->name; Down by probe $probe->name:$port")
                ->color('danger');
            });
    }
}
