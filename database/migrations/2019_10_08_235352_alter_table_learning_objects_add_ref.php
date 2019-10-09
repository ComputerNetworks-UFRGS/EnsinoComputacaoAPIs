<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableLearningObjectsAddRef extends Migration
{
    public function up()
    {
        Schema::table('learning_objects', function (Blueprint $table) {
            $table->char('ref', 8);
        });
    }

    public function down()
    {
        Schema::table('learning_objects', function (Blueprint $table) {
            $table->dropColumn('ref');
        });
    }
}
