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
        Schema::create('resolutions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('agenda_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUuid('committee_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('legally_binding_text');
            $table->string('state')->default('draft'); // draft, legal_review, voting, approved, rejected, signed
            $table->boolean('is_circular')->default(false);
            $table->dateTime('voting_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resolutions');
    }
};
