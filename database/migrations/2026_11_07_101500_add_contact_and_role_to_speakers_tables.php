<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            if (!Schema::hasColumn('speakers', 'profession')) {
                $table->string('profession')->nullable()->after('institution');
            }
            if (!Schema::hasColumn('speakers', 'email')) {
                $table->string('email')->nullable()->after('profession');
            }
            if (!Schema::hasColumn('speakers', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
        });

        Schema::table('event_speaker', function (Blueprint $table) {
            if (!Schema::hasColumn('event_speaker', 'role')) {
                $table->string('role')->default('Pemateri')->after('speaker_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            $cols = array_filter(['profession', 'email', 'phone'], function ($col) {
                return Schema::hasColumn('speakers', $col);
            });
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });

        Schema::table('event_speaker', function (Blueprint $table) {
            if (Schema::hasColumn('event_speaker', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};

