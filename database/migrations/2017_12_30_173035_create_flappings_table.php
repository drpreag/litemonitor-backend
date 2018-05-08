<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flappings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('host_id');
            $table->integer('service_id')->nullable();
            $table->string('comment', 128)->nullable();
            $table->boolean('status')->default(false);  

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
        Schema::dropIfExists('flappings');
    }
}
