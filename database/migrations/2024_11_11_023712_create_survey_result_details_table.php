<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_result_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_result_id')->constrained('survey_results')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('survey_questions')->cascadeOnDelete();
            $table->text('response_value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_result_details');
    }
};