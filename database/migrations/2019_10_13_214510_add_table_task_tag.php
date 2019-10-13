<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableTaskTag extends Migration
{

    public function up()
    {
        Schema::create('task_tags', function (Blueprint $table) {
            $table->unsignedInteger('task_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            $table->primary(['task_id', 'tag_id']);

            $table->foreign('task_id')
                ->references('id')->on('tasks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('task_tags');
    }
}
