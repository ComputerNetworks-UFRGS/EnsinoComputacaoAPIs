<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeafultToRole extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->integer('default')->default(0);
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('default');
        });
    }
}
