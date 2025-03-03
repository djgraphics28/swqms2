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
        Schema::create('device_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
            $table->string('temperature')->nullable();
            $table->string('ph_value')->nullable();
            $table->string('voltage')->nullable();
            $table->string('turbidity')->nullable();
            $table->string('conductivity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_logs');
    }
};
