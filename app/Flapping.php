<?php

namespace App;

use Illuminate\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Host;
use App\Service;

class Flapping extends Model
{
	//public $timestamps = false;

    /**
     * Relation
     *
     * @return App\Host
     */
    public function hasHost()
    {
        return $this->belongsTo('App\Host', 'host_id', 'id');
    }

    /**
     * Relation
     *
     * @return App\Service
     */
    public function hasService()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
    }

    public static function info ($host_id, $service_id=null, $comment, $status)
    {
        $flapping = new static;
        $flapping->host_id = $host_id;
        $flapping->service_id = $service_id;
        $flapping->comment = $comment;
        $flapping->status = $status;
        $flapping->save();

        return $flapping;
    }
}
