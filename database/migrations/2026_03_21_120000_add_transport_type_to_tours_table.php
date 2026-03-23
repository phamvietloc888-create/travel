<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tours') && ! Schema::hasColumn('tours', 'transport_type')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->string('transport_type')->nullable()->after('start_location');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('tours') && Schema::hasColumn('tours', 'transport_type')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->dropColumn('transport_type');
            });
        }
    }
};
