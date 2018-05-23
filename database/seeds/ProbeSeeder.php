<?php

use Illuminate\Database\Seeder;
use App\Probe;
use Carbon\Carbon as Carbon;

class ProbeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Probe::insert (['id'=>1, 'name'=>'Ping', 'ping_probe'=>'1', 'http_probe'=>'0',  'https_probe'=>'0',
            'ssh_probe'=>'0', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'1', 
            'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);        
        Probe::insert (['id'=>2, 'name'=>'Http', 'ping_probe'=>'0', 'http_probe'=>'1',  'https_probe'=>'0',
        	'ssh_probe'=>'0', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'1', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>3, 'name'=>'Https', 'ping_probe'=>'0', 'http_probe'=>'0',  'https_probe'=>'1',
        	'ssh_probe'=>'0', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'1', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>4, 'name'=>'Ssh', 'ping_probe'=>'0', 'http_probe'=>'0',  'https_probe'=>'0',
        	'ssh_probe'=>'1', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'1', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>5, 'name'=>'SSL', 'ping_probe'=>'0', 'http_probe'=>'0',  'https_probe'=>'0',
        	'ssh_probe'=>'0', 'ssl_probe'=>'1', 'mysql_probe'=>'0', 'draw_graph'=>'0', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>6, 'name'=>'MySQL', 'ping_probe'=>'0', 'http_probe'=>'0',  'https_probe'=>'0',
        	'ssh_probe'=>'0', 'ssl_probe'=>'0', 'mysql_probe'=>'1', 'draw_graph'=>'1', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
    }
}
