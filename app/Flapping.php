<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flapping extends Model
{
    //public $timestamps = false;

    /**
     * Relation
     *
     * @return \App\Host
     */
    public function host()
    {
        return $this->belongsTo('App\Host', 'host_id', 'id');
    }

    /**
     * Relation
     *
     * @return \App\Service
     */
    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id', 'id');
    }

    public static function info($host_id, $comment, $status, $service_id = null)
    {
        $flapping = new static;
        $flapping->host_id = $host_id;
        $flapping->comment = $comment;
        $flapping->status = $status;
        $flapping->service_id = $service_id;
        $flapping->save();

        return $flapping;
    }
}
