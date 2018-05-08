<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
//use App\Flapping;
//use App\Service;
//use App\Host;

class Flapping extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'host_id' => $this->host_id,
            'host_name' => $this->hasHost->name,
            'service_id' => $this->service_id,
            'service_name' => ($this->service_id) ? $this->hasService->name : '',    // derived
            'comment' => $this->comment,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString()
        ];

    }
}
