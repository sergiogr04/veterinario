<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();  // Laravel estándar para clave primaria
            $table->string('dni', 9);
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->string('direccion', 100);
            $table->string('telefono', 15);
            $table->string('email', 100);
            $table->string('password', 255);
            $table->string('rol'); 
            $table->string('remember_token', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
