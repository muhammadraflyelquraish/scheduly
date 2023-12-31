<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleMatkulClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_matkul_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_matkul_id')->constrained();
            $table->foreignId('class_id')->constrained('class', 'id');
            $table->integer('sks');
            $table->string('day');
            $table->string('hour');
            $table->string('room');
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
        Schema::dropIfExists('schedule_matkul_classes');
    }
}
