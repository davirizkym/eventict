<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            if (!Schema::hasColumn('speakers', 'city')) {
                $table->string('city')->nullable()->after('institution');
            }
            if (!Schema::hasColumn('speakers', 'topics')) {
                $table->text('topics')->nullable()->after('institution');
            }
            if (!Schema::hasColumn('speakers', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('institution');
            }
            if (!Schema::hasColumn('speakers', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('institution');
            }
        });
    }

    public function down(): void
    {
        Schema::table('speakers', function (Blueprint $table) {
            $cols = array_filter(['city', 'topics', 'is_featured', 'is_verified'], function ($col) {
                return Schema::hasColumn('speakers', $col);
            });
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
