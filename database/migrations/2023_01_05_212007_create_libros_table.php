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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_libro',100);
            $table->string('isbn_libro', 100);
            $table->string('dewey_libro',45);
            $table->text('resena_libro');
            $table->integer('numero_pagi_libro');
            $table->string('categoria_libro',45);
            $table->dateTime('fecha_publi_libro');
            $table->string('estado_libro',45);
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
        Schema::dropIfExists('libros');
    }
};
