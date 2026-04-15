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
        if (! Schema::hasColumn('brands', 'status')) {
            Schema::table('brands', function (Blueprint $table) {
                $table->enum('status', ['active', 'deactive'])->default('active')->after('brand_name');
            });
        }
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
