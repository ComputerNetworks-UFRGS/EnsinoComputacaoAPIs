<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->char('code', 4)->nullable();
            $table->text('description')->nullable();
            $table->text('recommended_approach')->nullable();
            $table->text('usage_suggestion')->nullable();
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('topic_types');
            $table->foreign('parent_id')->references('id')->on('topics');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
