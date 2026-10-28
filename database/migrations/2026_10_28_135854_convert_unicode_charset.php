<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $charset = 'utf8mb4';
        $collation = 'utf8mb4_unicode_ci';

        // Ensure the database connection uses utf8mb4 settings
        DB::statement("ALTER DATABASE `" . DB::connection()->getDatabaseName() . "` CHARACTER SET {$charset} COLLATE {$collation}");

        Schema::table('products', function (Blueprint $table) use ($charset, $collation) {
            // Convert text-capable columns to ensure utf8mb4
            $table->string('product_name')->charset($charset)->collation($collation)->change();
            $table->string('position')->nullable()->charset($charset)->collation($collation)->change();
            $table->text('user_description')->nullable()->charset($charset)->collation($collation)->change();
            $table->text('remarks')->nullable()->charset($charset)->collation($collation)->change();
        });

        Schema::table('categories', function (Blueprint $table) use ($charset, $collation) {
            $table->string('category_name')->charset($charset)->collation($collation)->change();
        });

        Schema::table('brands', function (Blueprint $table) use ($charset, $collation) {
            $table->string('brand_name')->charset($charset)->collation($collation)->change();
        });

        Schema::table('asset_models', function (Blueprint $table) use ($charset, $collation) {
            $table->string('model_name')->charset($charset)->collation($collation)->change();
        });
    }

    public function down(): void
    {
        // Rollback is limited; charset changes cannot be safely reversed without data loss risk.
        // Document this limitation in UPGRADE.md.
    }
};
