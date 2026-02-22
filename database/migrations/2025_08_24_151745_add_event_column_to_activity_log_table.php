<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventColumnToActivityLogTable extends Migration
{
    public function up()
    {
        $connection = config('activitylog.database_connection');
        $tableName = config('activitylog.table_name');

        if (Schema::connection($connection)->hasTable($tableName)) {
            Schema::connection($connection)->table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'event')) {
                    $table->string('event')->nullable(); // Removed 'after' for safety
                }
            });
        }
    }

    public function down()
    {
        $connection = config('activitylog.database_connection');
        $tableName = config('activitylog.table_name');

        if (Schema::connection($connection)->hasTable($tableName)) {
            Schema::connection($connection)->table($tableName, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'event')) {
                    $table->dropColumn('event');
                }
            });
        }
    }
}
