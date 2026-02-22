<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBatchUuidColumnToActivityLogTable extends Migration
{
    public function up()
    {
        $connection = config('activitylog.database_connection');
        $tableName = config('activitylog.table_name');

        if (
            Schema::connection($connection)->hasTable($tableName) &&
            !Schema::connection($connection)->hasColumn($tableName, 'batch_uuid')
        ) {
            Schema::connection($connection)->table($tableName, function (Blueprint $table) {
                $table->char('batch_uuid', 36)->nullable();
            });
        }
    }

    public function down()
    {
        $connection = config('activitylog.database_connection');
        $tableName = config('activitylog.table_name');

        if (
            Schema::connection($connection)->hasTable($tableName) &&
            Schema::connection($connection)->hasColumn($tableName, 'batch_uuid')
        ) {
            Schema::connection($connection)->table($tableName, function (Blueprint $table) {
                $table->dropColumn('batch_uuid');
            });
        }
    }
}
