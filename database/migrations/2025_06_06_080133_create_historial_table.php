<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->id();  // Laravel estándar para clave primaria
            $table->text('descripcion');
            $table->date('fecha');
            $table->string('peso');
            $table->string('historial_ibfk_1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
