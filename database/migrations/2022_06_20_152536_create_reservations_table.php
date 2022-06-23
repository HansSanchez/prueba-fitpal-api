<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(true); // ESTADO DE LA RESERVA
            $table->foreignId('lesson_id')->references('id')->on('lessons'); // LECCIÓN QUE RESERVA
            $table->foreignId('user_id')->references('id')->on('users'); // USUARIO QUE HACE LA RESERVA
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
        Schema::dropIfExists('reservations');
    }
}
