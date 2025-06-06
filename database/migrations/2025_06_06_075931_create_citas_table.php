<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();  
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo');
            $table->text('sintomas');
            $table->string('estado');
            $table->unsignedBigInteger('id_mascota');
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_mascota')->references('id_mascota')->on('mascotas')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
