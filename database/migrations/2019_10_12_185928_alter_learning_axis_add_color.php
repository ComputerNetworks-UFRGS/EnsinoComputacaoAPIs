<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLearningAxisAddColor extends Migration
{
    public function up()
    {
        Schema::table('learning_axis', function (Blueprint $table) {
            $table->string('color', 12)->nullable();
        });
    }

    public function down()
    {
        Schema::table('learning_axis', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
}
