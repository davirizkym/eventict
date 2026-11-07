<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('event_speaker', 'role')) {
            Schema::table('event_speaker', function (Blueprint $table) {
                $table->string('role')->default('Pembicara')->after('speaker_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('event_speaker', 'role')) {
            Schema::table('event_speaker', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};

