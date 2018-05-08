<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProbesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('probes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->boolean('http_probe')->default(false);
            $table->boolean('https_probe')->default(false);
            $table->boolean('socket_probe')->default(false);
            $table->boolean('ssl_probe')->default(false);
            $table->boolean('mysql_probe')->default(false);
            $table->boolean('draw_graph')->default(false);

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
        Schema::dropIfExists('probes');
    }
}
