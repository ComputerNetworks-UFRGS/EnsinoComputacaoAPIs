<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAxisAddPrintOrder extends Migration
{

    public function up()
    {
        Schema::table('learning_axis', function (Blueprint $table) {
            $table->integer('print_order')->nullable();
        });
    }

    public function down()
    {
        Schema::table('learning_axis', function (Blueprint $table) {
            $table->dropColumn('print_order');
        });
    }
}
