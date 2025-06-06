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
            $table->foreignId('id_mascota')->constrained('mascotas')->onDelete('cascade');
            $table->foreignId('id_cliente')->constrained('usuarios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
