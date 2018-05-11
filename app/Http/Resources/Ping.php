<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Ping extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,            
            'host_id' => $this->host_id,    
            'status' => $this->status,
            'avg_speed' => $this->avg_speed,
            'total_tests' => $this->total_tests,
            'failed_tests' => $this->failed_tests,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
