<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{

    /**
     * Relation
     *
     * @return App\Service
     */
    public function hasServices()
    {
        return $this->hasMany('App\Service', 'service_id');
    }

}
