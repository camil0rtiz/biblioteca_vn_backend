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
        Schema::create('ejemplares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_libro')->nullable();
            $table->unsignedBigInteger('id_editorial')->nullable();
            $table->foreign('id_libro')->references('id')->on('libros')->onDelete('cascade');
            $table->foreign('id_editorial')->references('id')->on('editoriales')->onDelete('cascade');
            $table->dateTime('fecha_edi_ejemplar')->nullable();
            $table->string('estado_ejemplar',45)->nullable();
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
        Schema::dropIfExists('ejemplares');
    }
};
