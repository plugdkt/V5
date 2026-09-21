<x-admin-layout>
    <x-slot name="title">คลังรูปภาพและไฟล์อัปโหลด (Media Manager)</x-slot>

    <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm">
        @livewire('admin.media-manager', ['pickerMode' => false])
    </div>
</x-admin-layout>
