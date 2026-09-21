<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_th');
            $table->string('title_en');
            $table->string('degree_full_th');
            $table->string('degree_abbr_th');
            $table->string('degree_full_en');
            $table->string('degree_abbr_en');
            $table->integer('credits');
            $table->integer('duration_years')->default(4);
            $table->integer('fee_per_semester');
            $table->string('curriculum_year');
            $table->longText('overview')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_color_from')->default('#064731');
            $table->string('hero_color_to')->default('#0B2545');
            $table->json('plos')->nullable();
            $table->json('curriculum')->nullable();
            $table->json('careers')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
