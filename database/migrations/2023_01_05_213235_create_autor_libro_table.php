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
        Schema::create('autor_libro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_autor');
            $table->unsignedBigInteger('id_libro');
            $table->foreign('id_autor')->references('id')->on('autores')->onDelete('cascade');
            $table->foreign('id_libro')->references('id')->on('libros')->onDelete('cascade');
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
        Schema::dropIfExists('autor_libro');
    }
};
