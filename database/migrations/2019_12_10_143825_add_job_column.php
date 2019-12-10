<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('jobs', function (Blueprint $table) {
            $table->string('location')->default('');
            $table->string('img_src')->default('');
            $table->string('salary')->default('');
            $table->enum('salary_period', ['Yearly', 'Monthly'])->default('Yearly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
