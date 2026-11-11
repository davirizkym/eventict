<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('events', 'skp_points')) {
                $columnsToDrop[] = 'skp_points';
            }
            if (Schema::hasColumn('events', 'sk_number')) {
                $columnsToDrop[] = 'sk_number';
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('skp_points')->default(0);
            $table->string('sk_number')->nullable();
        });
    }
};
