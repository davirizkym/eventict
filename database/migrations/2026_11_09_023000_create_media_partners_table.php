<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('media_partners')) {
            Schema::create('media_partners', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->string('institution')->nullable();
                $table->string('contact_email')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'media_partner_id')) {
                $table->foreignId('media_partner_id')->nullable()->after('organizer_type')->constrained('media_partners')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'media_partner_id')) {
                $table->dropForeign(['media_partner_id']);
                $table->dropColumn('media_partner_id');
            }
        });

        Schema::dropIfExists('media_partners');
    }
};
