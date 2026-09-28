<x-public-layout>
    <x-slot name="title">{{ $article->title_th }}</x-slot>
    <x-slot name="description">{{ Str::limit(strip_tags($article->excerpt ?? $article->body), 160) }}</x-slot>
    @if($article->cover_image)
        <x-slot name="ogImage">{{ asset('storage/' . ltrim(str_replace('/storage/', '', $article->cover_image), '/')) }}</x-slot>
    @endif
    <x-slot name="ogType">article</x-slot>

    @push('head')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "NewsArticle",
      "headline": {{ json_encode($article->title_th) }},
      "description": {{ json_encode(Str::limit(strip_tags($article->excerpt ?? $article->body), 160)) }},
      @if($article->cover_image)
      "image": [
        {{ json_encode(asset('storage/' . ltrim(str_replace('/storage/', '', $article->cover_image), '/'))) }}
      ],
      @endif
      "datePublished": {{ json_encode($article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String()) }},
      "dateModified": {{ json_encode($article->updated_at->toIso8601String()) }},
      "author": {
        "@type": "Person",
        "name": {{ json_encode($article->author ? $article->author->name : 'คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา') }}
      },
      "publisher": {
        "@type": "EducationalOrganization",
        "name": "คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา",
        "logo": {
          "@type": "ImageObject",
          "url": "{{ asset('storage/Logo_MedSci_th.webp') }}"
        }
      }
    }
    </script>
    @endpush

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

            {{-- Smart Auto-Translate Banner for English Users --}}
            @if(app()->getLocale() === 'en')
                <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div class="flex items-start gap-2.5">
                        <span class="text-base">🌐</span>
                        <div>
                            <div class="font-bold text-amber-900 font-prompt">{{ __('auto_translate_banner') }}</div>
                            <div class="text-amber-700 mt-0.5">{{ __('auto_translate_note') }}</div>
                        </div>
                    </div>
                    <a href="https://translate.google.com/translate?sl=th&tl=en&u={{ urlencode(request()->fullUrl()) }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-bold transition-all shadow-xs shrink-0">
                        <span>{{ __('translate_now') }}</span> ↗
                    </a>
                </div>
            @endif

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
