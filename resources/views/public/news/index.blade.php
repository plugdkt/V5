<x-public-layout>
    <x-slot name="title">
        {{ $category ? $category->name_th : 'ข่าวสารทั้งหมด' }}
    </x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-2">
                {{ $category ? $category->name_th : 'ข่าวสารและความเคลื่อนไหว' }}
            </h1>
            <p class="text-white/70 font-light text-sm">
                {{ $category ? 'ข่าวสารเฉพาะหมวดหมู่ ' . $category->name_th : 'ติดตามข่าวประชาสัมพันธ์ ข่าวกิจกรรม และจัดซื้อจัดจ้าง' }}
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        @livewire('public.news-grid', ['categorySlug' => $categorySlug, 'tagSlug' => $tagSlug])
    </div>
</x-public-layout>
