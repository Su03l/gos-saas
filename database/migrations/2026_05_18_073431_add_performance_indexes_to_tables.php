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
        Schema::table('execution_tasks', function (Blueprint $table) {
            $table->index(['assignee_id', 'status']);
        });

        Schema::table('resolutions', function (Blueprint $table) {
            $table->index(['committee_id', 'state']);
        });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->index(['causer_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('execution_tasks', function (Blueprint $table) {
            $table->dropIndex(['execution_tasks_assignee_id_status_index']);
        });

        Schema::table('resolutions', function (Blueprint $table) {
            $table->dropIndex(['resolutions_committee_id_state_index']);
        });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex(['activity_log_causer_id_created_at_index']);
        });
    }
};
