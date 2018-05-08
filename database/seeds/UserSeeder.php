<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon as Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::insert (['id'=>1, 'name'=>'drPreAG', 'email'=>'predrag.vlajkovic@gmail.com', 'password'=>'$2y$10$vsc.I6l9bxAVnN9WlvQoleGkfSSDjMqaO/ZoKnWOfRpSYUfciu4WG', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        User::insert (['id'=>2, 'name'=>'Zmajcek', 'email'=>'vlajkovicmarijana@gmail.com', 'password'=>'$2y$10$vsc.I6l9bxAVnN9WlvQoleGkfSSDjMqaO/ZoKnWOfRpSYUfciu4WG', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        User::insert (['id'=>3, 'name'=>'Iskra', 'email'=>'iskra@yahoo.com', 'password'=>'$2y$10$vsc.I6l9bxAVnN9WlvQoleGkfSSDjMqaO/ZoKnWOfRpSYUfciu4WG', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);
        User::insert (['id'=>4, 'name'=>'Oggy', 'email'=>'oggy.vlajkovic@gmail.com', 'password'=>'$2y$10$vsc.I6l9bxAVnN9WlvQoleGkfSSDjMqaO/ZoKnWOfRpSYUfciu4WG', 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]);    
    }
}
