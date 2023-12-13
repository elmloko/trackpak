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
        Schema::create('nacional', function (Blueprint $table) {
            $table->id();
            $table->string('CODIGO');
            $table->string('NOMBRESDESTINATARIO');
            $table->string('NOMBRESREMITENTE');
            $table->integer('TELEFONODESTINATARIO');
            $table->integer('TELEFONOREMITENTE');
            $table->integer('CIDESTINATARIO');
            $table->integer('CIREMITENTE');
            $table->integer('CANTIDAD');
            $table->string('TIPOSERVICIO');
            $table->string('TIPOCORRESPONDENCIA');
            $table->float('PESO');
            $table->string('DESTINO');
            $table->integer('FACTURA');
            $table->integer('IMPORTE');
            $table->string('ESTADO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nacional');
    }
};
