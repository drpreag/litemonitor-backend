<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Http\Resources\User as UserResource;

class Role extends JsonResource
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
            'name' => $this->name,
            'id' => $this->id,            
            //'description' => $this->description,
            //'active' => $this->active,
            //'created_at' => $this->created_at->toDateTimeString(),
            //'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
