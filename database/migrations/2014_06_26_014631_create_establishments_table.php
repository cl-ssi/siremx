<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('alias');
            $table->string('type');
            $table->string('old_code_deis');
            $table->string('new_code_deis');
            $table->string('service');
            $table->string('dependency');

            $table->unsignedBigInteger('commune_id');

            $table->foreign('commune_id')->references('id')->on('communes');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments');
    }
}
