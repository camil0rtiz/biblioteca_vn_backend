<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('id_vecino')->nullable();
            $table->unsignedBigInteger('id_bibliotecario')->nullable();
            $table->unsignedBigInteger('id_ejemplar')->nullable();
            $table->foreign('id_vecino')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_bibliotecario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_ejemplar')->references('id')->on('ejemplares')->onDelete('cascade');
            $table->dateTime('fecha_prestamo')->nullable(); //fecha en que se entrego el libro
            $table->dateTime('fecha_rece_prestamo')->nullable(); //fecha den que se recibio el libro
            $table->dateTime('fecha_entrega_prestamo')->nullable();//fecha en que se deberia entregar el libro
            $table->text('observaciones')->nullable();
            $table->string('estado_prestamo')->nullable();
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
        Schema::dropIfExists('prestamos');
    }
};
