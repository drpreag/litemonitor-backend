<?php

use Illuminate\Database\Seeder;
use App\Host;
use Carbon\Carbon as Carbon;

class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Host::insert (['id'=>1, 'name'=>'SoftwarePieces', 
        	'description'=>'Production',  'fqdn'=>'softwarepieces.com', 
        	'icmp_probe'=>'1', 'icmp_status'=>'0', 
        	'status_change'=>Carbon::now(), 
        	'last_status_down'=>Carbon::now(), 'last_status_up'=>Carbon::now(),
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
         Host::insert (['id'=>2, 'name'=>'Localhost', 
        	'description'=>'Localhost',  'fqdn'=>'localhost', 
        	'icmp_probe'=>'0', 'icmp_status'=>'0', 
        	'status_change'=>Carbon::now(), 
        	'last_status_down'=>Carbon::now(), 'last_status_up'=>Carbon::now(),
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
         Host::insert (['id'=>3, 'name'=>'Jatheon', 
        	'description'=>'Production',  'fqdn'=>'jatheon.com', 
        	'icmp_probe'=>'0', 'icmp_status'=>'0', 
        	'status_change'=>Carbon::now(), 
        	'last_status_down'=>Carbon::now(), 'last_status_up'=>Carbon::now(),
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
    }
}
