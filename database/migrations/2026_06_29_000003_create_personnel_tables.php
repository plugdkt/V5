<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('level')->nullable();
            $table->timestamps();
        });

        Schema::create('personnel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('employee_code')->nullable()->unique();
            $table->string('prefix')->nullable(); // นาย, นาง, นางสาว, ดร., ผศ.ดร. etc.
            $table->string('firstname_th');
            $table->string('lastname_th');
            $table->string('firstname_en')->nullable();
            $table->string('lastname_en')->nullable();
            $table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('set null');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->string('academic_position')->nullable(); // อาจารย์, ผู้ช่วยศาสตราจารย์, รองศาสตราจารย์, ศาสตราจารย์
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true); // active/inactive
            $table->timestamps();
        });

        Schema::create('personnel_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnel')->onDelete('cascade');
            $table->string('degree'); // ป.ตรี, ป.โท, ป.เอก
            $table->string('field'); // สาขาวิชา
            $table->string('institution'); // สถาบันการศึกษา
            $table->string('year')->nullable(); // ปีที่จบ
            $table->timestamps();
        });

        Schema::create('personnel_publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('personnel')->onDelete('cascade');
            $table->text('title');
            $table->string('journal')->nullable();
            $table->string('year')->nullable();
            $table->string('doi')->nullable();
            $table->string('type')->default('journal'); // journal, conference, book
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personnel_publications');
        Schema::dropIfExists('personnel_educations');
        Schema::dropIfExists('personnel');
        Schema::dropIfExists('positions');
        Schema::dropIfExists('departments');
    }
};
