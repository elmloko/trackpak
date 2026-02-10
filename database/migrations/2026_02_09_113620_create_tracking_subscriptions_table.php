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
         Schema::create('tracking_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 13)->index();
            $table->string('fcm_token', 255)->index();
            $table->string('last_sig', 255)->nullable();
            $table->timestamps();
            $table->unique(['codigo', 'fcm_token']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_subscriptions');
    }
};
