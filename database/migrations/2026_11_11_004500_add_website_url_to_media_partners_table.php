<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('media_partners')) {
            Schema::table('media_partners', function (Blueprint $table) {
                if (!Schema::hasColumn('media_partners', 'website_url')) {
                    $table->string('website_url')->nullable()->after('logo');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('media_partners') && Schema::hasColumn('media_partners', 'website_url')) {
            Schema::table('media_partners', function (Blueprint $table) {
                $table->dropColumn('website_url');
            });
        }
    }
};
