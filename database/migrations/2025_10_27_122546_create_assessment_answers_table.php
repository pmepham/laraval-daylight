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
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id');
            $table->foreignId('user_id');
            $table->foreignId('assessment_id');
            $table->foreignId('assessment_framework_id');
            $table->foreignId('assessment_framework_question_id');
            $table->foreignId('assessment_framework_option_id');
            $table->morphs('target');//client
            $table->longText('value');
            $table->timestamp('archived_at');//if an assessment is edited and the value has changed then archive this one and create a new one
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
    }
};
