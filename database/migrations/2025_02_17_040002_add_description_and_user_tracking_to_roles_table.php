<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('description');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['description', 'created_by', 'deleted_by']);
        });
    }
};
