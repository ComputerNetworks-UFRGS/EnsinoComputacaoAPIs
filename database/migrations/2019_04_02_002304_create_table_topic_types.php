<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTopicTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->tinyInteger('is_head')->default(0);
            $table->tinyInteger('is_leaf')->default(0);
            $table->unsignedInteger('learning_stage_id')->default(0);
            $table->timestamps();

            $table->foreign('learning_stage_id')->references('id')->on('learning_stages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topic_types');
    }
}
