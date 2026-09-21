<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->index(['location', 'active', 'order'], 'menu_items_location_active_order_idx');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->index(['status', 'published_at'], 'news_status_published_at_idx');
            $table->index(['category_id', 'status', 'published_at'], 'news_cat_status_published_idx');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index(['start_date'], 'events_start_date_idx');
        });

        Schema::table('personnel', function (Blueprint $table) {
            $table->index(['status'], 'personnel_status_idx');
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex('menu_items_location_active_order_idx');
        });
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('news_status_published_at_idx');
            $table->dropIndex('news_cat_status_published_idx');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex('events_start_date_idx');
        });
        Schema::table('personnel', function (Blueprint $table) {
            $table->dropIndex('personnel_status_idx');
        });
    }
};
