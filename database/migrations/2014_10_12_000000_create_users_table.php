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
            $table->string('nombre_usuario', 45);
            $table->string('apellido_pate_usuario', 45);
            $table->string('apellido_mate_usuario', 45);
            $table->string('email_usuario', 45)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password_usuario', 150);
            $table->integer('numero_casa_usuario');
            $table->string('calle_usuario', 45);
            $table->dateTime('fecha_naci_usuario');
            $table->string('estado_usuario', 10);
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
