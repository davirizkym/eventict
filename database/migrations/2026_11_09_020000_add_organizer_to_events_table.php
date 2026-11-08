<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'organizer_type')) {
                $table->string('organizer_type')->default('internal')->after('status');
            }
            if (!Schema::hasColumn('events', 'organizer_name')) {
                $table->string('organizer_name')->nullable()->after('organizer_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'organizer_name')) {
                $table->dropColumn('organizer_name');
            }
            if (Schema::hasColumn('events', 'organizer_type')) {
                $table->dropColumn('organizer_type');
            }
        });
    }
};
