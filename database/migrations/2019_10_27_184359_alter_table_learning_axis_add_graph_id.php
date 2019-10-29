<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableLearningAxisAddGraphId extends Migration
{

    public function up()
    {
        Schema::table('learning_axis', function (Blueprint $table) {
            $table->unsignedInteger('graph_id')->nullable();

            $table->foreign('graph_id')
                ->references('id')->on('graphs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    public function down()
    {
        Schema::table('learning_axis', function (Blueprint $table) {
            $table->dropColumn('graph_id');
        });
    }
}
