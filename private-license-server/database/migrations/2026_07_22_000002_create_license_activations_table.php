<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('license_activations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained()->cascadeOnDelete();
            $table->string('site_url')->nullable();
            $table->string('app_url')->nullable();
            $table->string('machine_id')->nullable();
            $table->string('server_ip')->nullable();
            $table->string('product_id');
            $table->string('app_version')->nullable();
            $table->enum('status', ['success', 'failed']);
            $table->string('message')->nullable();
            $table->timestamps();

            $table->index('license_id');
            $table->index('site_url');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('license_activations');
    }
};
