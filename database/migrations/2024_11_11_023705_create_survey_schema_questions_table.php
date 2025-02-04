<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_schema_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schema_id')->constrained('survey_schemas')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('survey_questions')->cascadeOnDelete();
            $table->integer('question_order');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_schema_questions');
    }
};