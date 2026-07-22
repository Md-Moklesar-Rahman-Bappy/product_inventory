<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable()->index();
            $table->text('description')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action')->nullable();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();

            $table->json('properties')->nullable();
            $table->string('event')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();

            $table->index(['log_name', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};