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
        Schema::create('membresia_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_membresia');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_membresia')->references('id')->on('membresias')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('fecha_pago_paga');
            $table->dateTime('fecha_venci_paga');
            $table->dateTime('fecha_acti_paga');

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
        Schema::dropIfExists('membresia_user');
    }
};
