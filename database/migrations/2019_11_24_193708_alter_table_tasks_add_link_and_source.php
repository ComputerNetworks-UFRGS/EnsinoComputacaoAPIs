<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTasksAddLinkAndSource extends Migration
{

    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('source')->nullable();
            $table->text('link')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('source');
            $table->dropColumn('link');
        });
    }
}
