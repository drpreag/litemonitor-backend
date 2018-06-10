<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Observation extends Resource
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
            'service_id' => $this->service_id,
            'probe_name' => $this->service->hasProbe->name,    // derived
            'status' => $this->status,
            'speed' => $this->speed,
            'result' => $this->result,
            'created_at' => $this->created_at->toTimeString()
        ];
    }
}
