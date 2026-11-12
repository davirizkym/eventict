<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (! Schema::hasColumn('registrations', 'is_checked_in')) {
                $table->boolean('is_checked_in')->default(false)->after('payment_status');
            }

            if (! Schema::hasColumn('registrations', 'attended_at')) {
                $table->timestamp('attended_at')->nullable()->after('attendance_status');
            }

            if (! Schema::hasColumn('registrations', 'attendance_gate')) {
                $table->string('attendance_gate')->nullable()->after('attended_at');
            }
        });

        if (Schema::hasColumn('registrations', 'qr_pass')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('qr_pass')->nullable()->change();
            });
        }

        if (Schema::hasColumn('registrations', 'is_checked_in') && Schema::hasColumn('registrations', 'checked_in_at')) {
            DB::table('registrations')
                ->whereNotNull('checked_in_at')
                ->update(['is_checked_in' => true]);
        }
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $dropCols = [];
            if (Schema::hasColumn('registrations', 'attendance_gate')) {
                $dropCols[] = 'attendance_gate';
            }
            if (Schema::hasColumn('registrations', 'attended_at')) {
                $dropCols[] = 'attended_at';
            }
            if (Schema::hasColumn('registrations', 'is_checked_in')) {
                $dropCols[] = 'is_checked_in';
            }
            if (! empty($dropCols)) {
                $table->dropColumn($dropCols);
            }
        });
    }
};
