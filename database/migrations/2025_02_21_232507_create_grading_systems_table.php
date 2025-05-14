<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_systems', function (Blueprint $table) {
            $table->id(); $table->string('grade'); // Grade (e.g., A, B, C)
            $table->unsignedTinyInteger('min_points'); // Minimum points for the grade
            $table->unsignedTinyInteger('max_points'); // Maximum points for the grade
            $table->string('remark'); // Remark (e.g., Excellent, Good)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grading_systems');
    }
}
