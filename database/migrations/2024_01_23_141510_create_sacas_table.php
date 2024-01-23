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
        Schema::create('sacas', function (Blueprint $table) {
            $table->id();
            $table->integer('NRODESPACHO');
            $table->string('OFCAMBIO');
            $table->string('OFDESTINO');
            $table->integer('NROSACAS');
            $table->integer('PESO');
            $table->integer('PAQUETES');
            $table->integer('ITINERARIO');
            $table->string('ESTADO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sacas');
    }
};
