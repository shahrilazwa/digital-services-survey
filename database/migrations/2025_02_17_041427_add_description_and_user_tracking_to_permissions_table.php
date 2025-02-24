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
        Schema::table('permissions', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->string('group')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('description');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['description', 'group', 'created_by', 'deleted_by']);
        });
    }
};
