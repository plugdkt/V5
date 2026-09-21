<x-public-layout>
    <x-slot name="title">บุคลากรและคณาจารย์</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                บุคลากรและคณาจารย์
            </h1>
            <p class="text-white/70 font-light text-sm">
                ทำเนียบบุคลากร คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        @livewire('public.personnel-list')
    </div>
</x-public-layout>
