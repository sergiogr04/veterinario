<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->id('id_historial');
            $table->text('descripcion');
            $table->date('fecha');
            $table->string('peso');
            $table->unsignedBigInteger('id_mascota');

            $table->foreign('id_mascota')->references('id_mascota')->on('mascotas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
