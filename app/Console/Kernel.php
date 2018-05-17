<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Host;
use App\Service;
use App\Observation;
use App\Ping;
use App\Probe;
use Carbon\Carbon as Carbon;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call (
            function() {
                $hosts = Host::where('icmp_probe', true)->get();
                foreach ($hosts as $host) {
                    $ping = new Ping;
                    $ping->pingMultipleTimes($host);
                    $ping->detectPingFlapping($host);
                }
            }
        )->name('ping')->withoutOverlapping()->everyMinute();

        $schedule->call (
            function() {
                $services = Service::where('active', true)->get();             // https/https ... probes
                foreach ($services as $service) {
                    if ($service->hasProbe->http_probe or $service->hasProbe->https_probe) {                    
                        $observation = new Observation;
                        $observation->curlProbe($service);
                        $service->detectProbeFlapping();
                    }
                }
            }
        )->name('curl')->withoutOverlapping()->everyMinute();

        $schedule->call (
            function() {
                $services = Service::where('active', true)->get();             // socket probes
                foreach ($services as $service) {
                    if ($service->hasProbe->socket_probe) {
                        $observation = new Observation;
                        $observation->socketProbe($service);
                        $service->detectProbeFlapping();
                    }
                }
            }
        )->name('other')->withoutOverlapping()->everyMinute();

        $schedule->call (
            function() {
                $services = Service::where('active', true)->get();             // mysql probes
                foreach ($services as $service) {
                    if ($service->hasProbe->mysql_probe) {
                        $observation = new Observation;
                        $observation->mysqlProbe($service);
                        $service->detectProbeFlapping();
                    }
                }
            }
        )->everyFiveMinutes();

        $schedule->call (
            function() {
                $services = Service::where('active', true)->get();             // ssl probes
                foreach ($services as $service) {
                    if ($service->hasProbe->ssl_probe) {
                        $observation = new Observation;
                        $observation->sslProbe($service);
                        $service->detectProbeFlapping();
                    }
                }
            }
        )->hourly();

        $schedule->call (
            function() {
                // delete records older that 2 days
                $ping = Ping::where('created_at','<',Carbon::now()->subDays(2)->toDateTimeString())->delete(); 
                $observation = Observation::where('created_at','<',Carbon::now()->subDays(2)->toDateTimeString())->delete();
            }
        )->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
