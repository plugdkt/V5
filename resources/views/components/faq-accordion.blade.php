@props([
    'items' => [],
    'title' => null,
    'subtitle' => null,
    'tag' => 'FAQ'
])

@php
    $isEn = app()->getLocale() === 'en';
    $resolvedTitle = $title ?? __('faq_title');
    $resolvedSubtitle = $subtitle ?? __('faq_subtitle');

    // Process items for current locale
    $processedItems = collect($items)->map(function($item) use ($isEn) {
        $q = $isEn ? ($item['q_en'] ?? $item['q'] ?? '') : ($item['q_th'] ?? $item['q'] ?? '');
        $a = $isEn ? ($item['a_en'] ?? $item['a'] ?? '') : ($item['a_th'] ?? $item['a'] ?? '');
        return [
            'question' => $q,
            'answer' => $a,
        ];
    })->filter(fn($i) => !empty($i['question']) && !empty($i['answer']))->values();
@endphp

@if($processedItems->isNotEmpty())
<section class="py-16 bg-white border-t border-border-gray/60" id="faq-section" x-data="{ openIndex: null }">
    <div class="max-w-[1000px] mx-auto px-6">
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-teal/10 text-teal uppercase tracking-widest mb-3">
                <span class="w-2 h-2 rounded-full bg-teal animate-pulse"></span>
                {{ $tag }}
            </span>
            <h2 class="font-prompt text-2.5xl md:text-3xl font-extrabold text-navy tracking-tight">
                {{ $resolvedTitle }}
            </h2>
            @if($resolvedSubtitle)
                <p class="text-sm md:text-base text-muted font-light mt-2 leading-relaxed">
                    {{ $resolvedSubtitle }}
                </p>
            @endif
        </div>

        {{-- Accordion List --}}
        <div class="space-y-4">
            @foreach($processedItems as $index => $item)
                <div class="border border-border-gray/80 rounded-2xl overflow-hidden transition-all duration-200 bg-white"
                     :class="openIndex === {{ $index }} ? 'border-teal/50 shadow-md ring-1 ring-teal/20' : 'hover:border-slate-300 shadow-xs'">
                    
                    <button type="button"
                            @click="openIndex = openIndex === {{ $index }} ? null : {{ $index }}"
                            class="w-full text-left px-6 py-5 flex items-center justify-between gap-4 select-none focus:outline-none focus-visible:ring-2 focus-visible:ring-teal cursor-pointer">
                        <span class="font-prompt font-semibold text-sm md:text-base text-navy flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shrink-0 transition-colors"
                                  :class="openIndex === {{ $index }} ? 'bg-teal text-white' : 'bg-slate-100 text-slate-500'">
                                {{ $index + 1 }}
                            </span>
                            <span>{{ $item['question'] }}</span>
                        </span>
                        
                        <span class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center shrink-0 text-slate-500 transition-transform duration-200"
                              :class="openIndex === {{ $index }} ? 'rotate-180 bg-teal/10 text-teal' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>

                    <div x-show="openIndex === {{ $index }}"
                         x-collapse
                         x-cloak>
                        <div class="px-6 pb-6 pt-1 text-sm md:text-base text-slate-600 font-light leading-relaxed border-t border-slate-100 mt-1 pl-15">
                            {!! nl2br(e($item['answer'])) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Schema.org FAQPage for Rich Snippets & AEO --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    @foreach($processedItems as $index => $item)
    {
      "@type": "Question",
      "name": {{ json_encode($item['question']) }},
      "acceptedAnswer": {
        "@type": "Answer",
        "text": {{ json_encode(strip_tags($item['answer'])) }}
      }
    }{{ $loop->last ? '' : ',' }}
    @endforeach
  ]
}
</script>
@endif
