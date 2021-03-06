<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Service extends Resource
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
            'name' => $this->name,

            'host_id' => $this->host_id,
            'host_name' => $this->host->name,    // derived
            'probe_id' => $this->probe_id,
            'probe_name' => $this->hasProbe->name,  // derived
            'port' => $this->port,
            'uri' => $this->uri,

            'active' => $this->active,
            'status' => $this->status,

            'status_change' => $this->status_change,
            'last_status_down' => $this->last_status_down,
            'last_status_up' => $this->last_status_up,

            'username' => $this->username,
            'password' => $this->password,

            'draw_graph' => $this->hasProbe->draw_graph,  // derived

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
