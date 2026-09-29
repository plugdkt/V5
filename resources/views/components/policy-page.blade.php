@props(['title', 'updated' => '29 กันยายน 2569'])
{{-- Shared layout for the policy pages required by มาตรฐานเว็บไซต์ภาครัฐ เวอร์ชัน 3.0 (มสพร. 11-2566) ข้อ 8.9 และ 10 --}}
<x-public-layout>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="description">{{ $title }} เว็บไซต์คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="flex items-center gap-2 text-xs text-white/50 mb-3 font-semibold">
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">หน้าแรก</a>
                <span>·</span>
                <span class="text-white/80">{{ $title }}</span>
            </div>
            <h1 class="font-prompt text-3xl font-bold mb-1">{{ $title }}</h1>
            <p class="text-white/70 font-light text-sm">เว็บไซต์คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา · ปรับปรุงล่าสุด {{ $updated }}</p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-[1fr_260px] gap-8">
        <article class="bg-white rounded-2xl border border-border-gray p-6 md:p-10 shadow-sm policy-content text-[15px] leading-relaxed text-[#1A1A2E]">
            {{ $slot }}
        </article>

        <aside class="space-y-2 text-sm">
            <div class="font-prompt font-bold text-navy mb-2">นโยบายและประกาศของเว็บไซต์</div>
            @foreach(\App\Http\Controllers\Public\SiteController::POLICY_PAGES as $slug => $name)
                <a href="{{ route('pages.show', $slug) }}"
                   class="block px-4 py-2.5 rounded-xl border {{ request()->is('pages/' . $slug) ? 'bg-navy text-white border-navy' : 'bg-white border-border-gray text-navy hover:border-teal hover:text-teal' }} transition-colors">
                    {{ $name }}
                </a>
            @endforeach
            <a href="{{ route('sitemap.page') }}" class="block px-4 py-2.5 rounded-xl border bg-white border-border-gray text-navy hover:border-teal hover:text-teal transition-colors">ผังเว็บไซต์</a>
        </aside>
    </div>

    @push('styles')
        <style>
            .policy-content h2 { font-family: 'Prompt', sans-serif; font-size: 1.15rem; font-weight: 700; color: #0B2545; margin: 1.75rem 0 .6rem; }
            .policy-content h2:first-child { margin-top: 0; }
            .policy-content h3 { font-weight: 700; color: #0B2545; margin: 1.1rem 0 .4rem; }
            .policy-content p { margin: .5rem 0; }
            .policy-content ul, .policy-content ol { padding-left: 1.4rem; margin: .5rem 0; }
            .policy-content ul { list-style: disc; }
            .policy-content ol { list-style: decimal; }
            .policy-content li { margin: .25rem 0; }
            .policy-content table { width: 100%; border-collapse: collapse; margin: .75rem 0; font-size: 14px; }
            .policy-content th, .policy-content td { border: 1px solid #E2E8F0; padding: .5rem .65rem; text-align: left; vertical-align: top; }
            .policy-content th { background: #F1F5F9; }
            .policy-content a { color: #0F766E; text-decoration: underline; }
        </style>
    @endpush
</x-public-layout>
