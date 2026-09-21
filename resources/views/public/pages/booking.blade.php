<x-public-layout>
    <x-slot name="title">จองห้องประชุมออนไลน์</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                จองห้องประชุมออนไลน์
            </h1>
            <p class="text-white/70 font-light text-sm">
                ระบบตรวจเช็คคิวและส่งคำขออนุมัติจองห้องประชุม คณะวิทยาศาสตร์การแพทย์
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        @livewire('public.room-booking-form')
    </div>
</x-public-layout>
