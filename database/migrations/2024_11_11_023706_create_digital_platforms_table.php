<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('digital_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name')->unique();
            $table->string('abbreviation')->nullable();
            $table->enum('type', ['Web System', 'Mobile App', 'Portal']);
            $table->string('ea_cluster')->nullable();
            $table->string('url');
            $table->text('description')->nullable();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->onDelete('set null');
            $table->foreignId('org_id')->nullable()->constrained('organizations')->onDelete('set null');            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('digital_platforms');
    }
};