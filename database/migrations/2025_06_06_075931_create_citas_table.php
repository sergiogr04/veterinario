<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();  // Laravel estándar para clave primaria
            $table->date('fecha');
            $table->time('hora');
            $table->string('tipo'); // original enum
            $table->text('sintomas');
            $table->string('estado'); // original enum
            $table->integer('id_mascota');
            $table->integer('id_cliente');
            $table->string('citas_ibfk_1'); // tipo original: FOREIGN
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
