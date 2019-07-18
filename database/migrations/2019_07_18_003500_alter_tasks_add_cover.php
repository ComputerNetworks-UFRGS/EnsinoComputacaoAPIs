<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTasksAddCover extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('cover')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('cover');
        });
    }
}
