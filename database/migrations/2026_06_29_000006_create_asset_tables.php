<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('asset_categories')->onDelete('set null');
            $table->string('code')->nullable(); // e.g., COM, LAB, FUR
            $table->timestamps();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('asset_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('asset_code')->unique()->nullable(); // รหัสครุภัณฑ์
            $table->string('serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->double('purchase_price')->default(0);
            $table->string('location')->nullable(); // สถานที่จัดเก็บ
            $table->string('condition')->default('good'); // new, good, fair, poor, disposed
            $table->foreignId('responsible_person_id')->nullable()->constrained('personnel')->onDelete('set null');
            $table->string('status')->default('available'); // available, borrowed, maintenance, disposed
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('asset_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('type'); // in, out, transfer, maintenance, dispose, borrow, return
            $table->foreignId('from_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('to_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->date('date');
            $table->text('note')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_transactions');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('asset_categories');
    }
};
