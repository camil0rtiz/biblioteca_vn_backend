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
            $table->string('titulo_libro',100)->nullable();
            $table->string('dewey_libro',60)->nullable();
            $table->string('anio_publi_libro',20)->nullable();
            $table->integer('stock_libro')->nullable()->default(0);
            $table->text('resena_libro')->nullable();
            $table->tinyInteger('estado_libro')->nullable();
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
