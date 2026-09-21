<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('title_th');
            $table->string('title_en')->nullable();
            $table->string('url'); // e.g. /about, https://reg.up.ac.th
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->string('target')->default('_self'); // _self, _blank
            $table->string('location')->default('header'); // header, footer_about, footer_programs, footer_services
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
