<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Host;
use App\Flapping;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Ping extends Model
{
    //public $timestamps = false;

    /**
     * Count one ping response time to host
     *
     * @return float time in miliseconds, or -1 if ping failed
     */	
	function pingOnce (string $host) {

	    $startTime = microtime(true);
	    $ping = exec('ping -c 1 ' . $host);
	    $stopTime  = microtime(true);

		$elapsedTime = (($stopTime - $startTime) *1000);

	    if (strpos ($ping, "min/avg/max")!==false)
	    	return $elapsedTime;
	    else 
	    	return -1;
	}

    /**
     * Count AVG ping for 5 probes
     *
     * saves new record to table
     * @return -1 site down, 0 failed at least one pings, >0 ping avg speed
     */
    public function pingMultipleTimes(Host $host)
    {
        $testNumber = env('PING_COUNT', 5);
        
        $status = true;
        $totalTime = 0.0;
        $failedTests = 0;

        for ($i=0; $i<$testNumber; $i++) {

            $result = $this->pingOnce ($host->fqdn);

            if ($result >= 0)
                $totalTime = $totalTime + $result;
            else {
                $failedTests++;
                sleep(0.5);
            }
        }

        $this->host_id = $host->id;
        $this->total_tests = $testNumber;
        $this->failed_tests = $failedTests;     
        if ($failedTests < $testNumber) {
            $this->status = true;
            $this->avg_speed = round ($totalTime / ($testNumber-$failedTests), 2);         
        }
        $this->save();
        
        if ($failedTests == 0)
            return round ($totalTime / $testNumber, 2);
        else
            if ($failedTests == $testNumber) 
                return -1;
            else
                return 0;
    }

    /**
     * If Ping status for Host is flaping then log to Flapping and Log models
     *
     * 
     */
    public function detectPingFlapping (Host &$host)
    {
        $lastTwo = Ping::where('host_id', $host->id)->orderBy('id', 'desc')->take(2)->get();

        if ($lastTwo->count()>=2) {
            $counter = 1;
            foreach ($lastTwo as $pingProbe) {
                if ($counter==1)
                    $new = $pingProbe;
                else
                    $old = $pingProbe;
                $counter++;
            }

            if ($old->status == true and $new->status == false) {
                // flaping from Up to Down
                Log::info ("$host->name ($host->id) Ping Down, status changed, id=$this->id");
                Flapping::info ($host->id, null, "Ping Down", false);
                $host->status_change = Carbon::now(); 
                $host->last_status_down = Carbon::now(); 
                $host->icmp_status = false;
                $host->save(); 
            } 
            if ($old->status == false and $new->status == true) {
                // flaping from Down to Up
                Log::info ("$host->name ($host->id) Ping Up, status changed, id=$this->id");
                Flapping::info ($host->id, null, "Ping Up", true);
                $host->status_change = Carbon::now();                
                $host->last_status_up = Carbon::now();
                $host->icmp_status = true;
                $host->save();
            }
            if ($new->status==true and $host->icmp_status==false) {
                Log::info ("$host->name ($host->id) Ping Up, status fixed, id=$this->id");            
                $host->icmp_status = true;
                $host->save();
            }
        }
    }    
}
