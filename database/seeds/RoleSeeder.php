<?php

use Illuminate\Database\Seeder;
use App\Role;
use Carbon\Carbon as Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Role::insert (['id'=>1, 'name'=>'Active user', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Role::insert (['id'=>2, 'name'=>'Reader', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);    	
        Role::insert (['id'=>3, 'name'=>'Contributor', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Role::insert (['id'=>4, 'name'=>'Writer', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);        
        Role::insert (['id'=>5, 'name'=>'Moderator', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Role::insert (['id'=>6, 'name'=>'Editor', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Role::insert (['id'=>7, 'name'=>'Editor in chief', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Role::insert (['id'=>8, 'name'=>'Administrator', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        Role::insert (['id'=>9, 'name'=>'Super administrator', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
    }
}
