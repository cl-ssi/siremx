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

            $table->string('servicio_salud')->nullable();
            $table->string('profesional_solicita')->nullable();
            $table->string('diagnostico')->nullable();
            $table->string('establecimiento_realiza_examen')->nullable();
            $table->string('cesfam')->nullable();
            $table->string('medico')->nullable();
            $table->string('fonasa')->nullable();


            $table->date('date_exam_order')->nullable(); // Fecha de Solicitud
            $table->date('date_exam')->nullable(); // Fecha Exámen
            $table->date('date_exam_reception')->nullable();
            $table->string('derivation_reason')->nullable();
            $table->string('birards_mamografia')->nullable();
            $table->string('birards_ecografia')->nullable();
            $table->string('result')->nullable();

            // VARIABLES DE CONTROL
            $table->enum('load_source',['excel', 'app', 'other']);
            $table->unsignedBigInteger('load_id');

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
