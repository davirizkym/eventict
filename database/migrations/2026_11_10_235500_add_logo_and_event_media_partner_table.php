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
                if (!Schema::hasColumn('media_partners', 'logo')) {
                    $table->string('logo')->nullable()->after('slug');
                }
            });
        }

        if (!Schema::hasTable('event_media_partner')) {
            Schema::create('event_media_partner', function (Blueprint $table) {
                $table->id();
                $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
                $table->foreignId('media_partner_id')->constrained('media_partners')->cascadeOnDelete();
                $table->timestamps();

                $table->unique(['event_id', 'media_partner_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('event_media_partner');

        if (Schema::hasTable('media_partners') && Schema::hasColumn('media_partners', 'logo')) {
            Schema::table('media_partners', function (Blueprint $table) {
                $table->dropColumn('logo');
            });
        }
    }
};
