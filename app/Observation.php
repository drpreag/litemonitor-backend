<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Host;
use App\Service;
use Carbon\Carbon;
use Spatie\SslCertificate\SslCertificate;

class Observation extends Model
{
    /**
     * Relation
     *
     * @return App\Service
     */
    public function hasService()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
    }

    /**
     * Count one ping response time to host
     *
     * @return float time in miliseconds, or -1 if ping failed
     */	
	private function pingOnce (string $host) {

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
    public function pingProbe(Service $service)
    {
        $testNumber = env('PING_COUNT', 5);
        $host = Host::findOrFail($service->host_id);
        
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

        $this->service_id = $service->id;     
        if ($failedTests == $testNumber) {
            $this->status = false;
            $this->result = "All pings failed";
            $this->speed = null;
        } else {
        	if ($failedTests > 1) {
	        	$this->speed = round ($totalTime / ($testNumber-$failedTests), 2);
            	$this->status = false;
            	$this->result = "$failedTests of $testNumber pings failed";         
            } else {
	        	$this->speed = round ($totalTime / ($testNumber-$failedTests), 2);
            	$this->status = true;
            	$this->result = "OK";         
            }
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

	function socketProbe (Service &$service)
	{
		set_time_limit(0);

		if (! $service->hasProbe->socket_probe)		
			return;

	    $starttime = microtime(true);
	   	$status    = false;

	    $file      = @fsockopen ($service->hasHost->fqdn, $service->port, $errno, $errstr, 10);
		$stoptime  = microtime(true);	    

		if (is_resource($file)) 
		    if ($file) {
		        fclose($file);
	    		$status = true;
		    }

		$this->service_id = $service->id;
		$this->status = $status;
		$this->speed = round (($stoptime - $starttime) * 1000, 3);
		$this->save();

	    return $status;
	}

	function curlProbe (Service $service)
	{   
		set_time_limit(0);

	   	$starttime = microtime(true);

	   	if ($service->hasProbe->http_probe) {
			$url="http://" . $service->hasHost->fqdn . $service->uri;
			if (isset($service->port))		
				$port = $service->port;				
			else
				$port = 80;		
	   	}
  		if ($service->hasProbe->https_probe) {
			$url="https://" . $service->hasHost->fqdn . $service->uri;
			if (isset($service->port))		
				$port = $service->port;				
			else				
				$port = 443;					
  		}
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PORT, $port);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_exec($ch);
		if (!curl_errno($ch)) 
			$result = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		else 
			$result = "Error";        

        curl_close($ch); 
	    $stoptime  = microtime(true);

		if ($result==200)
			$status = true;
		else {
			$status = false;
		}

		$this->service_id = $service->id;
		$this->status = $status;
		$this->speed = round (($stoptime - $starttime) * 1000, 3);
		$this->result = substr ($result, 0, 127);
		$this->save();

		return $status;
	}	

	function mysqlProbe (Service &$service)
	{
		set_time_limit(0);
		
		if (! $service->hasProbe->mysql_probe)		
			return;

		$starttime = microtime(true);
		$conn = new \mysqli($service->hasHost->fqdn .':'. $service->port, $service->username, $service->password, 'information_schema');
	    $stoptime  = microtime(true);	

		$this->service_id = $service->id;
		if (!$conn) 
			$this->status = false;
		else
			$this->status = true;		
		$this->result = $conn->connect_errno;	// ne prikazuje errno kako treba, popraviti
		$this->speed = round (($stoptime - $starttime) * 1000, 3);
		$this->save();	    

		if (!$conn) {
			return false;
		}
		return true;
	}

	function sslProbe (Service &$service)
	{
		if (! $service->hasProbe->ssl_probe)
			return;
		try {
			$certificate = SslCertificate::createForHostName($service->hasHost->fqdn);

			$this->service_id = $service->id;
			if ($certificate->isValid()) 
				$this->status = true;
			else
				$this->status = false;
			$this->result = $certificate->getIssuer();		
			$this->save();

		    return $certificate->isValid();
		} catch (\Spatie\SslCertificate\Exceptions\CouldNotDownloadCertificate $t) {
			$this->service_id = $service->id;			
			$this->status = false;			
			$this->result = "Invalid certificate";
			$this->save();			
    		return false;
		}
	}	
}
