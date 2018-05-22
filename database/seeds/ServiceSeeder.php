<?php

use Illuminate\Database\Seeder;
use App\Service;
use Carbon\Carbon as Carbon;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert (['id'=>1, 'name'=>'SoftwarePieces web site', 
        	'host_id'=>'1', 'probe_id'=>'2', 'port'=>'443', 'uri'=>'', 
        	'active'=>'1', 'status'=>'1', 
        	'status_change'=>Carbon::now(),         	
        	'last_status_down'=>Carbon::now(), 'last_status_up'=>Carbon::now(),
        	'user'=>'', 'pass'=>'', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Service::insert (['id'=>2, 'name'=>'SoftwarePieces web site', 
        	'host_id'=>'1', 'probe_id'=>'4', 'port'=>'', 'uri'=>'', 
        	'active'=>'1', 'status'=>'1', 
        	'status_change'=>Carbon::now(),         	
        	'last_status_down'=>Carbon::now(), 'last_status_up'=>Carbon::now(),
            'user'=>'', 'pass'=>'', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]); 
        Service::insert (['id'=>3, 'name'=>'Jatheon web site', 
        	'host_id'=>'3', 'probe_id'=>'2', 'port'=>'443', 'uri'=>'', 
        	'active'=>'1', 'status'=>'0', 
        	'status_change'=>Carbon::now(),         	
        	'last_status_down'=>Carbon::now(), 'last_status_up'=>Carbon::now(),
        	'user'=>'', 'pass'=>'', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
    }
}
