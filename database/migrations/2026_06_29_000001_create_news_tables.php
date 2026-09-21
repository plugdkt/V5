<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('slug')->unique();
            $table->string('color')->default('#1B6CA8');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('news_categories')->onDelete('cascade');
            $table->string('title_th');
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('draft'); // draft, published
            $table->timestamp('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });

        Schema::create('news_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('news_news_tag', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('news_tags')->onDelete('cascade');
            $table->primary(['news_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_news_tag');
        Schema::dropIfExists('news_tags');
        Schema::dropIfExists('news');
        Schema::dropIfExists('news_categories');
    }
};
