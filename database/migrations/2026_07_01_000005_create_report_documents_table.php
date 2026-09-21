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
        Schema::create('report_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_category_id')->constrained('report_categories')->onDelete('cascade');
            $table->string('group_name');
            $table->string('sub_group_name')->nullable();
            $table->string('title');
            $table->text('file_path');
            $table->text('file_path_excel')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_documents');
    }
};
