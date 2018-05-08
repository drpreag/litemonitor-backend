<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('RoleSeeder');
        $this->call('RolePermissionSeeder');

        $this->call('ProbeSeeder');
        $this->call('HostSeeder');
        $this->call('ServiceSeeder');

    }
}
