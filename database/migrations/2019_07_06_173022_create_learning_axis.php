<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLearningAxis extends Migration
{
    public function up()
    {
        Schema::create('learning_axis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('learning_stages_id');
            $table->timestamps();

            $table->foreign('learning_stages_id')
                ->references('id')
                ->on('learning_stages')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_axis');
    }
}
