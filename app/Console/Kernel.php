<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Host;
use App\Service;
use App\Observation;
use Carbon\Carbon as Carbon;

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
        $schedule->call(
            function () {
                $services = Service::where('active', true)->get();             // ping probes
                foreach ($services as $service) {
                    if ($service->hasProbe->ping_probe) {
                        $observation = new Observation;
                        $observation->pingProbe($service);
                        $service->detectProbeFlapping();
                    }
                }
            }
        )->name('ping')->withoutOverlapping()->everyMinute();


        $schedule->call(
            function () {
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

        $schedule->call(
            function () {
                $services = Service::where('active', true)->get();             // ssh probes
                foreach ($services as $service) {
                    if ($service->hasProbe->ssh_probe) {
                        $observation = new Observation;
                        $observation->sshProbe($service);
                        $service->detectProbeFlapping();
                    }
                }
            }
        )->name('ssh')->withoutOverlapping()->everyMinute();

        $schedule->call(
            function () {
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

        $schedule->call(
            function () {
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

        $schedule->call(
            function () {
                $hosts = Host::where('active', true)->get();                // collect geoIP data for each host
                foreach ($hosts as $host) {
                    $host->getGeoIPData();
                }
            }
        )->hourly();
        
        $schedule->call(
            function () {
                // delete records with status OK older that 2 days, we keep all status not_OK for good
                $observation = Observation::where('created_at', '<', Carbon::now()
                                            ->where('status', 1)
                                            ->subDays(2)->toDateTimeString())
                                            ->delete();
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
