<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use App\Notifications\HostDown;
use App\Notifications\HostUp;
use Illuminate\Support\Facades\Log;
use App\Flapping;
use Carbon\Carbon;
use App\Ping;

class Host extends Model
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        return env('SLACK_API');
    }

    public function ping()
    {
        $ping = new Ping;
        return ($ping->pingMultipleTimes($this));
    }

    /**
     * If Ping status for Host is flaping (compare two last flapping for a host) 
     *    then log to Flapping and Log models
     *    then send Slack notification
     */
    public function detectPingFlapping ()
    {
        $lastTwo = Ping::where('host_id', $this->id)->orderBy('id', 'desc')->take(2)->get();

        if ($lastTwo->count()>=2) {
            $counter = 1;
            foreach ($lastTwo as $pingProbe) {
                if ($counter==1)
                    $new = $pingProbe;
                else
                    $old = $pingProbe;
                $counter++;
            }

            if ($old->status == true and $new->status == false) {
                // flaping from Up to Down
                Log::info ("$this->name ($this->id) Ping Down, status changed, id=$this->id");
                Flapping::info ($this->id, null, "Ping Down", false);
                $this->notify(new HostDown); // send Slack notification
                $this->status_change = Carbon::now(); 
                $this->last_status_down = Carbon::now(); 
                $this->icmp_status = false;
                $this->save(); 
            } 
            if ($old->status == false and $new->status == true) {
                // flaping from Down to Up
                Log::info ("$this->name ($this->id) Ping Up, status changed, id=$this->id");
                Flapping::info ($this->id, null, "Ping Up", true);
                $this->notify(new HostUp); // send Slack notification
                $this->status_change = Carbon::now();                
                $this->last_status_up = Carbon::now();
                $this->icmp_status = true;
                $this->save();
            }
            if ($new->status==true and $this->icmp_status==false) {
                Log::info ("$this->name ($this->id) Ping Up, status fixed, id=$this->this->id");            
                $this->icmp_status = true;
                $this->save();
            }
        }
    }            
}
