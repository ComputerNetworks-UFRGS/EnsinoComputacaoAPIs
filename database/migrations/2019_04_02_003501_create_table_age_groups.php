<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgeGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 4);
            $table->string('name');
            $table->float('age_from');
            $table->float('age_to');
            $table->unsignedInteger('learning_stage_id');
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
        Schema::dropIfExists('age_groups');
    }
}
