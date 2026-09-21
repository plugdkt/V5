<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity')->default(10);
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('amenities')->nullable(); // projector, microphone, whiteboard, smart_tv, etc.
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('meeting_rooms')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title'); // หัวข้อการประชุม
            $table->text('purpose')->nullable(); // วัตถุประสงค์
            $table->integer('attendees')->nullable(); // จำนวนผู้เข้าร่วม
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('status')->default('pending'); // pending, approved, rejected, cancelled
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('note')->nullable(); // หมายเหตุ หรือเหตุผลการ reject
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
        Schema::dropIfExists('meeting_rooms');
    }
};
