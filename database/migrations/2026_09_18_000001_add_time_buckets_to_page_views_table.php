<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->unsignedInteger('views_morning')->default(0)->after('views_tablet');
            $table->unsignedInteger('views_afternoon')->default(0)->after('views_morning');
            $table->unsignedInteger('views_evening')->default(0)->after('views_afternoon');
            $table->unsignedInteger('views_night')->default(0)->after('views_evening');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn(['views_morning', 'views_afternoon', 'views_evening', 'views_night']);
        });
    }
};
