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
        	'active'=>'1',
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
         Host::insert (['id'=>2, 'name'=>'Localhost', 
        	'description'=>'Localhost',  'fqdn'=>'localhost', 
        	'active'=>'0',
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
         Host::insert (['id'=>3, 'name'=>'Jatheon', 
        	'description'=>'Production',  'fqdn'=>'jatheon.com', 
        	'active'=>'0',
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
    }
}
