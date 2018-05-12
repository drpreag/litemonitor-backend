<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    /**
     * Relation
     *
     * @return App\User
     */
    public function users()
    {
        return $this->hasMany('App\User', 'role_id');
    }

}
