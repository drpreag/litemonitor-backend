<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Service;

class ServiceEmailNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $service;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->service->status == true) {
            // Service UP email
            return $this->view('emails.service_email')
                ->subject('Service Up - ' . $this->service->name)
                ->with('service', $this->service);
        } else {
            // Service DOWN email
            return $this->view('emails.service_email')
                ->subject('Service Down - ' . $this->service->name)
                ->with('service', $this->service);
        }    
    }
}
