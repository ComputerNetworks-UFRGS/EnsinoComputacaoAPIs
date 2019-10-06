<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGraphsAddGroupByYear extends Migration
{

    public function up()
    {
        Schema::table('graphs', function (Blueprint $table) {
            $table->boolean('group_by_year')->default(false)->nullable();
        });
    }

    public function down()
    {
        Schema::table('graphs', function (Blueprint $table) {
            $table->dropColumn('group_by_year');
        });
    }
}
