<x-public-layout>
    <x-slot name="title">ปฏิทินกิจกรรม</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                ปฏิทินกิจกรรมคณะ
            </h1>
            <p class="text-white/70 font-light text-sm">
                ตารางกิจกรรม วันสำคัญ และปฏิทินการศึกษา คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
            @livewire('public.event-calendar')
        </div>
    </div>
</x-public-layout>
