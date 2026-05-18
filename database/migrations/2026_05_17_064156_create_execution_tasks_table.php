<?php

declare(strict_types=1);

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
        Schema::create('execution_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('resolution_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assignee_id')->constrained('users')->cascadeOnDelete();
            $table->text('task_description');
            $table->date('sla_deadline');
            $table->string('status')->default('pending'); // pending, in_progress, evidence_submitted, closed, escalated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('execution_tasks');
    }
};
