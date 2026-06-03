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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('user_id');
            $table->foreignId('assessment_framework_id');
            $table->foreignId('client_id');
            $table->json('assessment_snapshot')->nullable(); // just incase the assessment is changed
            $table->timestamp('completed_at')->nullable(); // mark the assessment as completed
            $table->timestamp('closed_at')->nullable(); // close the assesment so that no more edits can be made. can be opened by admins
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
