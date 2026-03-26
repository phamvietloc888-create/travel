<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('tours', 'hotel_name') || ! Schema::hasColumn('tours', 'hotel_stars')) {
            Schema::table('tours', function (Blueprint $table) {
                if (! Schema::hasColumn('tours', 'hotel_name')) {
                    $table->string('hotel_name')->nullable()->after('start_location');
                }

                if (! Schema::hasColumn('tours', 'hotel_stars')) {
                    $table->unsignedTinyInteger('hotel_stars')->nullable()->after('hotel_name');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn(['hotel_name', 'hotel_stars']);
        });
    }
};
