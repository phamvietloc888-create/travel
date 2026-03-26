<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bookings')) {
            return;
        }

        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('note');
            }

            if (!Schema::hasColumn('bookings', 'payment_ready_at')) {
                $table->timestamp('payment_ready_at')->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('bookings', 'customer_notice')) {
                $table->text('customer_notice')->nullable()->after('payment_ready_at');
            }

            if (!Schema::hasColumn('bookings', 'customer_notice_read_at')) {
                $table->timestamp('customer_notice_read_at')->nullable()->after('customer_notice');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('bookings')) {
            return;
        }

        Schema::table('bookings', function (Blueprint $table) {
            $columns = [];

            foreach (['admin_note', 'payment_ready_at', 'customer_notice', 'customer_notice_read_at'] as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $columns[] = $column;
                }
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
