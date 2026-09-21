<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., แบบฟอร์มสำหรับนิสิต, แบบฟอร์มสำหรับบุคลากร, ประกาศต่างๆ
            $table->foreignId('parent_id')->nullable()->constrained('file_categories')->onDelete('set null');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('downloadable_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('file_categories')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('filename'); // saved path/filename in local storage
            $table->string('original_name'); // original file name uploaded
            $table->string('mime_type')->nullable();
            $table->integer('size')->default(0); // size in bytes
            $table->integer('download_count')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downloadable_files');
        Schema::dropIfExists('file_categories');
    }
};
