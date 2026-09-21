<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->unsignedInteger('views_desktop')->default(0)->after('views_count');
            $table->unsignedInteger('views_mobile')->default(0)->after('views_desktop');
            $table->unsignedInteger('views_tablet')->default(0)->after('views_mobile');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn(['views_desktop', 'views_mobile', 'views_tablet']);
        });
    }
};
