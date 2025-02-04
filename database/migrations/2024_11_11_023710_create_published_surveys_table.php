<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('published_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('survey_link')->nullable();
            $table->foreignId('schema_id')->nullable()->constrained('survey_schemas')->cascadeOnDelete();
            $table->foreignId('execution_team_id')->nullable()->constrained('teams')->cascadeOnDelete();
            $table->foreignId('digital_platform_service_id')->nullable()->constrained('digital_platform_service')->cascadeOnDelete();
            $table->dateTime('publication_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['Draft', 'Closed', 'Published', 'Archived'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('published_surveys');
    }
};