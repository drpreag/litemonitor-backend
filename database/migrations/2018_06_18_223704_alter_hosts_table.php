<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hosts', function($table) {
            $table->string('ip')->length(16)->default(null);
            $table->decimal('latitude', 9, 6)->default(null);
            $table->decimal('longitude', 9, 6)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hosts', function($table) {
            $table->dropColumn ('ip');
            $table->dropColumn ('latitude');
            $table->dropColumn ('longitude');
        });
    }
}
