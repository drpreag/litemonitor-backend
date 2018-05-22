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
    public function hasService()
    {
        return $this->hasMany('App\Service', 'service_id');
    }

}
