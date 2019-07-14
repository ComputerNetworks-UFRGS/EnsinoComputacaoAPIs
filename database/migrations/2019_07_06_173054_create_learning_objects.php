<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningObjects extends Migration
{
    public function up()
    {
        Schema::create('learning_objects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('learning_axis_id');
            $table->timestamps();

            $table->foreign('learning_axis_id')
                ->references('id')
                ->on('learning_axis')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_objects');
    }
}
