<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->string('object');
            $table->boolean('b')->default(false);
            $table->boolean('r')->default(false);
            $table->boolean('e')->default(false);
            $table->boolean('a')->default(false);
            $table->boolean('d')->default(false);
            $table->string('description')->nullable();
            
            $table->timestamps();
        });  

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
