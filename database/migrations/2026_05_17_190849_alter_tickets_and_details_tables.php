<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->foreignId('created_by')->nullable()->after('project_id')->constrained('users')->cascadeOnDelete();
        });

        Schema::table('ticket_details', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->renameColumn('report', 'more_information');
        });
    }

    public function down(): void
    {
        Schema::table('ticket_details', function (Blueprint $table) {
            $table->renameColumn('more_information', 'report');
            $table->string('description')->nullable();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['description', 'created_by']);
        });
    }
};