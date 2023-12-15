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
        Schema::table('nationals', function (Blueprint $table) {
            $table->string('DIRECCION');
            $table->string('PROVINCIA');
            $table->string('MUNICIPIO');
            $table->string('ORIGEN');
            $table->string('USER');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nationals', function (Blueprint $table) {
            $table->dropColumn('DIRECCION');
            $table->dropColumn('PROVINCIA');
            $table->dropColumn('MUNICIPIO');
            $table->dropColumn('ORIGEN');
            $table->dropColumn('USER');
        });
    }
};
