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
        $ip = gethostbyname($this->fqdn);
        if (! filter_var($ip, FILTER_VALIDATE_IP))
            $ip = null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            
            'fqdn' => $this->fqdn,
            'ip' => $ip,

            'active' => $this->active, 

            // 'status_change' => $this->status_change,
            // 'last_status_down' => $this->last_status_down,
            // 'last_status_up' => $this->last_status_up,

            //'created_at' => $this->created_at,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];        
    }
}
