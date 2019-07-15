<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableLearningObjectAddAgeGroup extends Migration
{
    public function up()
    {
        Schema::table('learning_objects', function (Blueprint $table) {
            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups');
        });
    }

    public function down()
    {
        Schema::table('learning_objects', function (Blueprint $table) {
            $table->dropColumn('age_group_id');
        });
    }
}
