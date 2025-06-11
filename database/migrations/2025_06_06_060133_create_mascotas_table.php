<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id('id_mascota'); // nombre correcto de tu PK según tu captura
            $table->string('nombre', 50);
            $table->string('especie', 50);
            $table->string('raza', 50);
            $table->date('fecha_nacimiento');
            $table->string('foto', 255)->nullable();
            $table->unsignedBigInteger('id_cliente'); // relación con usuarios

            $table->foreign('id_cliente')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
