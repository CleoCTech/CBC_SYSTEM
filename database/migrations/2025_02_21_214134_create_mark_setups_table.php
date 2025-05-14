<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_setups', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('ca1'); // CA1 marks (e.g., 20)
            $table->unsignedTinyInteger('ca2'); // CA2 marks (e.g., 20)
            $table->unsignedTinyInteger('exam'); // EXAM marks (e.g., 60)
            $table->unsignedTinyInteger('total')->default(100); // TOTAL marks (must be 100)
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
        Schema::dropIfExists('mark_setups');
    }
}
