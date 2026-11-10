<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->after('payment_status');
            $table->string('snap_token')->nullable()->after('midtrans_order_id');
            $table->string('payment_method')->nullable()->after('snap_token');
            $table->integer('amount_paid')->default(0)->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('amount_paid');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['midtrans_order_id', 'snap_token', 'payment_method', 'amount_paid', 'paid_at']);
        });
    }
};
