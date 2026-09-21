<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->date('view_date')->index();
            $table->string('path', 255)->index();
            $table->string('page_title', 255)->nullable();
            $table->unsignedInteger('views_count')->default(1);
            $table->timestamps();

            $table->unique(['view_date', 'path']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
