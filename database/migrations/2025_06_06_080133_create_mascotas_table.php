<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();  // Laravel estándar para clave primaria
                        $table->string('nombre', 50);
            $table->string('especie', 50);
            $table->string('raza', 50);
            $table->date('fecha_nacimiento');
            $table->string('foto', 255);
            $table->string('mascotas_ibfk_1'); // tipo original: FOREIGN
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
