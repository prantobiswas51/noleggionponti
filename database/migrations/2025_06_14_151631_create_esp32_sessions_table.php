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
        Schema::create('esp32_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esp32_device_id')->constrained()->onDelete('cascade');
    $table->timestamp('started_at');
    $table->timestamp('expires_at');
    $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esp32_sessions');
    }
};
