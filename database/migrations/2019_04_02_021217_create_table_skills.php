<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 32);
            $table->text('name');
            $table->integer('sequential_number')->default(1);
            $table->unsignedInteger('learning_stage_id');
            $table->unsignedInteger('age_group_id');
            $table->unsignedInteger('topic_id');
            $table->timestamps();

            $table->foreign('learning_stage_id')->references('id')->on('learning_stages');
            $table->foreign('age_group_id')->references('id')->on('age_groups');
            $table->foreign('topic_id')->references('id')->on('topics');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');
    }
}
