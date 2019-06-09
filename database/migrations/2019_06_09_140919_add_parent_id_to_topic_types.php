<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentIdToTopicTypes extends Migration
{
    public function up()
    {
        Schema::table('topic_types', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('topic_types')->onDelete('set null')->onUpdate('set null');
        });
    }

    public function down()
    {
        Schema::table('topic_types', function (Blueprint $table) {
            $table->dropForeign('topic_types_parent_id_foreign');
            $table->dropColumn('parent_id');
        });
    }
}
