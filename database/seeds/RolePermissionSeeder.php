<?php

use Illuminate\Database\Seeder;
use App\RolePermission;
use Carbon\Carbon as Carbon;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		RolePermission::insert (['id'=>1, 'role_id'=>1, 'object'=>"Users",
			'b'=>true, 'r'=>false, 'e'=>false, 'a'=>false, 'd'=>false, 
			'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);

		RolePermission::insert (['id'=>2, 'role_id'=>1, 'object'=>"Roles",
			'b'=>true, 'r'=>false, 'e'=>false, 'a'=>false, 'd'=>false, 
			'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);

		RolePermission::insert (['id'=>3, 'role_id'=>9, 'object'=>"Users",
			'b'=>true, 'r'=>true, 'e'=>true, 'a'=>true, 'd'=>true, 
			'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);

		RolePermission::insert (['id'=>4, 'role_id'=>9, 'object'=>"Roles",
			'b'=>true, 'r'=>true, 'e'=>true, 'a'=>true, 'd'=>true, 
			'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
    }
}
