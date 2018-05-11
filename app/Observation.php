<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Host;
use App\Service;
use Carbon\Carbon;
use Spatie\SslCertificate\SslCertificate;

class Observation extends Model
{

	//public $timestamps = false;

    /**
     * Relation
     *
     * @return App\Service
     */
    public function hasService()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
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
