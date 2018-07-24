<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Host extends Model
{

    /**
     * Relation
     *
     * @return \App\Service
     */
    public function hasService()
    {
        return $this->hasMany('App\Service', 'service_id');
    }

    /**
     * populate attributes: ip, latitude, longitude
     *
     */
    public function getGeoIPData()
    {
        $geoIPApiKey = env('GEOIP_API');
        
        $this->ip = gethostbyname($this->fqdn);

        if (! filter_var($this->ip, FILTER_VALIDATE_IP)) {
            $this->ip = null;
        }
        
        if ($this->ip != null) {
            $url = ("https://api.ipdata.co/". $this->ip . "?api-key=" . $geoIPApiKey);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_PORT, 443);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            
            $json_result = json_decode($result, true);
            $this->latitude = floatval($json_result['latitude']);
            $this->longitude = floatval($json_result['longitude']);
            Log::info("Host geoInfo: " . $this->name . ", IP:" . $this->ip .
                        " with geoipdata:" . $this->latitude. ", " . $this->longitude);
            $this->save();
        }
        return $this;
    }
}
