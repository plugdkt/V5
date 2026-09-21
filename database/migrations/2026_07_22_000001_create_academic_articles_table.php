<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('division')->nullable();
            $table->string('category')->default('other'); // biochemistry, microbiology, nutrition, physiology, anatomy, other
            $table->string('link_url')->nullable();
            $table->text('abstract')->nullable();
            $table->date('published_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_articles');
    }
};
