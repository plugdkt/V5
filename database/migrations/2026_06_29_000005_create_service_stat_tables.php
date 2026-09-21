<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., บริการวิเคราะห์สิ่งส่งตรวจ, บริการตรวจสุขภาพ
            $table->string('unit')->default('ราย'); // e.g., ราย, ครั้ง, ตัวอย่าง
            $table->text('description')->nullable();
            $table->string('category')->nullable(); // e.g., ห้องแล็บ, บริการวิชาการ, ตรวจสอบ
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('service_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_type_id')->constrained('service_types')->onDelete('cascade');
            $table->foreignId('reported_by')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('period_year'); // e.g., 2026
            $table->integer('period_month'); // e.g., 6 (June)
            $table->double('value')->default(0); // count of service usage
            $table->text('note')->nullable();
            $table->timestamps();
            
            $table->unique(['service_type_id', 'period_year', 'period_month'], 'service_period_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_stats');
        Schema::dropIfExists('service_types');
    }
};
