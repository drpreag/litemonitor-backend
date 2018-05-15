<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon as Carbon;

class Host extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            
            'fqdn' => $this->fqdn,
            'ip' => gethostbyname($this->fqdn),     //derrived

            'icmp_probe' => $this->icmp_probe, 
            'icmp_status' => $this->icmp_status,

            'status_change' => $this->status_change,
            'last_status_down' => $this->last_status_down,
            'last_status_up' => $this->last_status_up,

            //'created_at' => $this->created_at,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];        
    }
}
