<x-public-layout>
    <x-slot name="title">
        {{ $article->title_th }}
    </x-slot>

    <div class="max-w-[1200px] mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-[2.5fr_1fr] gap-10">
        {{-- Main Article --}}
        <article class="bg-white rounded-2xl border border-border-gray p-6 md:p-8">
            {{-- Category & Date info --}}
            <div class="flex items-center gap-3 mb-4 flex-wrap">
                <span class="bg-teal/10 text-teal text-xs font-bold tracking-wider uppercase px-2.5 py-1 rounded">
                    {{ $article->category->name_th }}
                </span>
                <span class="text-xs text-muted flex items-center gap-1">
                    <span>📅</span> {{ $article->published_at->locale('th')->translatedFormat('d F Y') }}
                </span>
                <span class="text-xs text-muted flex items-center gap-1">
                    <span>👁️</span> {{ $article->view_count }} ครั้ง
                </span>
            </div>

            {{-- Title --}}
            <h1 class="font-prompt text-2xl md:text-3xl font-bold text-navy mb-6 leading-snug">
                {{ $article->title_th }}
            </h1>

            {{-- Cover Image --}}
            @if($article->cover_image)
                <div class="rounded-xl overflow-hidden mb-8 border border-border-gray max-h-[500px]">
                    <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title_th }}" class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Body HTML content --}}
            <div class="prose md:prose-lg max-w-none text-[#1A1A2E] leading-relaxed font-normal space-y-4">
                {!! $article->body !!}
            </div>


            {{-- Share/Footer --}}
            <div class="border-t border-border-gray mt-10 pt-6 flex justify-between items-center text-xs text-muted">
                <span>เขียนโดย: {{ $article->author ? $article->author->name : 'ผู้ดูแลระบบ' }}</span>
                <div class="flex gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                       class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 font-semibold transition-colors">
                        Share on Facebook
                    </a>
                </div>
            </div>
        </article>

        {{-- Related News Sidebar --}}
        <aside class="space-y-6">
            <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm">
                <h3 class="font-prompt text-base font-bold text-navy mb-4 border-b border-border-gray pb-3">
                    ข่าวสารที่เกี่ยวข้อง
                </h3>
                <div class="flex flex-col gap-4">
                    @forelse($relatedNews as $rel)
                        <a href="{{ route('news.show', $rel->slug) }}" class="group">
                            <h4 class="text-sm font-semibold text-navy leading-snug group-hover:text-teal transition-colors line-clamp-2 mb-1.5">
                                {{ $rel->title_th }}
                            </h4>
                            <div class="text-[10px] text-muted">
                                📅 {{ $rel->published_at->locale('th')->translatedFormat('d M y') }}
                            </div>
                        </a>
                    @empty
                        <div class="text-xs text-muted py-2">ไม่มีข่าวสารที่เกี่ยวข้อง</div>
                    @endforelse
                </div>
            </div>
            
            <div class="bg-navy rounded-2xl p-6 text-white text-center relative overflow-hidden">
                <div class="font-prompt text-lg font-bold mb-2">สนใจศึกษาต่อ?</div>
                <p class="text-xs text-white/75 font-light mb-4 leading-relaxed">
                    ค้นหาหลักสูตรการเรียนการสอนและทุนการศึกษาที่น่าสนใจของคณะวิทยาศาสตร์การแพทย์
                </p>
                <a href="{{ route('programs') }}" class="btn-primary w-full py-2.5 text-xs text-center">
                    ดูข้อมูลหลักสูตร
                </a>
            </div>
        </aside>
    </div>
</x-public-layout>
