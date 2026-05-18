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
        Schema::create('meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('committee_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end');
            $table->string('meeting_link')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, active, concluded, minuted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
