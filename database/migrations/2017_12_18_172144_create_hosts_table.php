<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('description', 255);
            $table->string('fqdn', 255);
            $table->boolean('icmp_probe')->default(true);
            $table->boolean('icmp_status')->default(false);
            $table->timestamp('status_change')->useCurrent();
            $table->timestamp('last_status_down')->useCurrent();
            $table->timestamp('last_status_up')->useCurrent();
            
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
        Schema::dropIfExists('hosts');
    }
}
