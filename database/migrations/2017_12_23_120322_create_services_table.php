<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->integer('host_id');
            $table->integer('probe_id');
            $table->integer('port')->nullable();
            $table->string('uri', 128)->nullable();            
            $table->boolean('active')->default(true);
            $table->boolean('status')->default(false);
            $table->timestamp('status_change')->nullable();
            $table->timestamp('last_status_down')->nullable();
            $table->timestamp('last_status_up')->nullable();
            $table->string('username', 64)->nullable();
            $table->string('password', 64)->nullable();

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
        Schema::dropIfExists('services');
    }
}
