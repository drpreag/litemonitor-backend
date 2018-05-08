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
        Probe::insert (['id'=>1, 'name'=>'Http', 'http_probe'=>'1',  'https_probe'=>'0',
        	'socket_probe'=>'0', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'1', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>2, 'name'=>'Https', 'http_probe'=>'0',  'https_probe'=>'1',
        	'socket_probe'=>'0', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'1', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>3, 'name'=>'Ssh', 'http_probe'=>'0',  'https_probe'=>'0',
        	'socket_probe'=>'1', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'0', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>4, 'name'=>'Ftp', 'http_probe'=>'0',  'https_probe'=>'0',
        	'socket_probe'=>'1', 'ssl_probe'=>'0', 'mysql_probe'=>'0', 'draw_graph'=>'0', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>5, 'name'=>'SSL', 'http_probe'=>'0',  'https_probe'=>'0',
        	'socket_probe'=>'0', 'ssl_probe'=>'1', 'mysql_probe'=>'0', 'draw_graph'=>'0', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Probe::insert (['id'=>6, 'name'=>'MySQL', 'http_probe'=>'0',  'https_probe'=>'0',
        	'socket_probe'=>'0', 'ssl_probe'=>'0', 'mysql_probe'=>'1', 'draw_graph'=>'1', 
        	'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
    }
}
