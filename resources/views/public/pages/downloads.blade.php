<x-public-layout>
    <x-slot name="title">ดาวน์โหลดแบบฟอร์มเอกสาร</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                แบบฟอร์มและเอกสารดาวน์โหลด
            </h1>
            <p class="text-white/70 font-light text-sm">
                ศูนย์รวมแบบฟอร์มคำร้อง เอกสารวิชาการ และระเบียบประกาศ คณะวิทยาศาสตร์การแพทย์
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        @livewire('public.download-browser')
    </div>
</x-public-layout>
