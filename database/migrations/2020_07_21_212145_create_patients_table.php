<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('run')->nullable();
            //$table->unsignedInteger('run')->nullable();
            $table->char('dv')->nullable();
            $table->string('other_identification')->nullable();
            $table->string('name')->nullable();
            $table->string('fathers_family')->nullable();
            $table->string('mothers_family')->nullable();
            $table->enum('gender',['male', 'female', 'other', 'unknown']);
            $table->date('birthday')->nullable();
            $table->string('telephone')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->nullable();
            $table->datetime('deceased_at')->nullable();
            $table->rememberToken(); 
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
        Schema::dropIfExists('patients');
    }
}
