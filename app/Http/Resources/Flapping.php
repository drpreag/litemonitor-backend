<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon as Carbon;
//use App\Service;

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
        return [
            'id' => $this->id,
            'host_id' => $this->host_id,
            'host_name' => $this->hasHost->name,    // derived
            'service_id' => $this->service_id,
            'service_name' => ($this->service_id !== null) ? $this->hasService->name : '',    // derived
            'comment' => $this->comment,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString()
        ];

    }
}
