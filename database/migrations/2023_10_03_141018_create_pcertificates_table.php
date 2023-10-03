<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pcertificates', function (Blueprint $table) {
            $table->id();
            $table->string('CODIGO');
            $table->string('DESTINATARIO');
            $table->string('DIRECCION');
            $table->integer('TELEFONO');
            $table->string('PAIS');
            $table->string('CUIDAD');
            $table->string('ZONA');
            $table->string('VENTANILLA');
            $table->float('PESO');
            $table->string('TIPO');
            $table->string('ESTADO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcertificates');
    }
};
