<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Events\ServiceDownEvent;
use App\Events\ServiceUpEvent;

class Service extends Model
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        return env('SLACK_API');
    }
    
    /**
     * Relation
     *
     * @return \App\Probe
     */
    public function hasProbe()
    {
        return $this->hasOne('App\Probe', 'id', 'probe_id');
    }

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
     * @return \App\Observation
     */
    public function hasObservations()
    {
        return $this->hasMeny('App\Observation', 'service_id');
    }

    /**
     * Relation
     *
     * @return \App\Observation
     */
    public function hasFlappings()
    {
        return $this->hasMeny('App\Flapping', 'id', 'service_id');
    }

    /**
     * If Probe status for Host is flaping then send Slack notifications
     *
     *
     */
    public function detectProbeFlapping()
    {
        $lastTwo = Observation::where('service_id', $this->id)->orderBy('id', 'desc')->take(2)->get();

        if ($lastTwo->count()>=2) {
            $counter = 1;
            foreach ($lastTwo as $hostProbe) {
                if ($counter==1) {
                    $new = $hostProbe;
                } else {
                    $old = $hostProbe;
                }
                $counter++;
            }
            if ($old->status == true and $new->status == false) {
                // flaping from Up to Down
                $this->status_change = Carbon::now();
                $this->last_status_down = Carbon::now();
                $this->status = false;
                $this->save();
                Log::info("$this->host_id Down, status changed, id=$this->id");
                Flapping::info($this->host_id, $this->id, "Down by probe " . $this->hasProbe->name, false);
                event(new ServiceDownEvent($this));
            }
            if ($old->status == false and $new->status == true) {
                // flaping from Down to Up
                $this->status_change = Carbon::now();
                $this->last_status_up = Carbon::now();
                $this->status = true;
                $this->save();
                Log::info("$this->host_id Up, status changed id=$this->id");
                Flapping::info($this->host_id, $this->id, "Up by probe ". $this->hasProbe->name, true);
                event(new ServiceUpEvent($this));
            }
            if ($this->status == false and $new->status == true) {
                Log::info("$this->host_id Probe Up, status fixed id= $this->id");
                $this->status = true;
                $this->status_change = Carbon::now();
                $this->save();
            }
        }
    }
}
