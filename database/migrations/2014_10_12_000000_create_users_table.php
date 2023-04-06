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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('rut_usuario', 45)->unique();
            $table->string('nombre_usuario', 45)->nullable();
            $table->string('apellido_pate_usuario', 45)->nullable();
            $table->string('apellido_mate_usuario', 45)->nullable();
            $table->string('email', 45)->unique();
            $table->integer('numero_tele_usuario')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->integer('numero_casa_usuario')->nullable();
            $table->string('calle_usuario', 45)->nullable();
            $table->date('fecha_naci_usuario')->nullable();
            $table->tinyInteger('estado_usuario')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
