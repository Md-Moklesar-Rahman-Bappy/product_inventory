<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('license_key')->unique();
            $table->string('product_id');
            $table->string('site_url')->nullable();
            $table->string('app_url')->nullable();
            $table->string('machine_id')->nullable();
            $table->string('server_ip')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired', 'revoked'])->default('inactive');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_check_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'status']);
            $table->index('customer_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
