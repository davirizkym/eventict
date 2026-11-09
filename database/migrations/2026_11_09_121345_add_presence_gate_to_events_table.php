<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'is_presence_open')) {
                $table->boolean('is_presence_open')->default(false)->after('virtual_meeting_url');
            }
            if (!Schema::hasColumn('events', 'presence_token')) {
                $table->string('presence_token')->nullable()->after('is_presence_open');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'presence_token')) {
                $table->dropColumn('presence_token');
            }
            if (Schema::hasColumn('events', 'is_presence_open')) {
                $table->dropColumn('is_presence_open');
            }
        });
    }
};
