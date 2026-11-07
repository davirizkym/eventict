<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->string('color')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('slug')->constrained('categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('events', 'type')) {
                $table->string('type')->default('Workshop')->after('category');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('events', 'type')) {
                $table->dropColumn('type');
            }
        });

        Schema::dropIfExists('categories');
    }
};
