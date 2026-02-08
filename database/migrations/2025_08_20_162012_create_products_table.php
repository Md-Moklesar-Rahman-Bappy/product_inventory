<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Core product info
            $table->string('product_name');
            $table->decimal('price', 10, 2)->default(0.00); // 💰 Product price with precision
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('brand_id')->constrained('brands')->onDelete('cascade');
            $table->foreignId('model_id')->constrained('asset_models')->onDelete('cascade');

            // Serial numbers
            $table->char('serial_no', 100)->unique();
            $table->char('project_serial_no', 100)->unique();

            // Optional metadata
            $table->string('position')->nullable();
            $table->text('user_description')->nullable();
            $table->text('remarks')->nullable();

            // Warranty tracking
            $table->dateTime('warranty_start')->nullable();
            $table->dateTime('warranty_end')->nullable()->index(); // indexed for filtering

            // Soft delete + timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
