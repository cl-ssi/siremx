<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->date('date_exam_order')->nullable();
            $table->date('date_exam')->nullable();
            $table->date('date_exam_reception')->nullable();
            $table->string('derivation_reason')->nullable();
            $table->string('birards')->nullable();
            $table->string('result')->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('patient_id');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
