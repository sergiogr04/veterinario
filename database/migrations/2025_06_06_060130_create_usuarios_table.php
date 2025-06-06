<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('dni', 9)->unique();
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->string('direccion')->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('email', 100);
            $table->string('password', 255);
            $table->string('rol');
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
