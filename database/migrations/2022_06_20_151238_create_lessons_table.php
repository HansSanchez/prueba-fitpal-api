<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('coach'); // ENTRENADOR(A)
            $table->string('location'); // UBICACIÓN
            $table->integer('limit')->nullable(); // AFORO MÁXIMO
            $table->enum('type', ['ONLINE', 'PRESENTIAL', 'ENGRAVED']); // TIPO DE LECCIÓN
            $table->foreignId('schedule_id')->references('id')->on('schedules'); // HORARIO DE LA LECCIÓN
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
        Schema::dropIfExists('lessons');
    }
}
