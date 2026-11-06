<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('Teknologi & Rekayasa');
            $table->enum('format', ['offline', 'online', 'hybrid'])->default('hybrid');
            $table->string('location')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('quota')->default(100);
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('skp_points')->default(0);
            $table->string('sk_number')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'published', 'completed', 'cancelled'])->default('published');
            $table->string('banner_url')->nullable();
            $table->string('virtual_meeting_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
