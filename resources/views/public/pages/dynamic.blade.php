<x-public-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <div class="bg-navy py-12 text-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                {{ $title }}
            </h1>
            <p class="text-white/70 font-light text-sm">
                คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-10 shadow-sm">
            <div class="prose md:prose-lg max-w-none text-[#1A1A2E] leading-relaxed font-normal space-y-4">
                @php
                    $processedContent = preg_replace_callback(
                        '/(src|href)=["\']([^"\']*(?:storage)[^"\']*)["\']/i',
                        function ($matches) {
                            $attr = $matches[1];
                            $url = $matches[2];
                            if (preg_match('/storage\/(.*)$/i', $url, $subMatches)) {
                                return $attr . '="' . asset('storage/' . ltrim($subMatches[1], '/')) . '"';
                            }
                            return $matches[0];
                        },
                        $content
                    );

                    $bottomContent = '';
                    if (preg_match('/<!--\s*page-bottom-start\s*-->(.*?)<!--\s*page-bottom-end\s*-->/s', $processedContent, $bottomMatches)) {
                        $bottomContent = $bottomMatches[1];
                        $processedContent = str_replace($bottomMatches[0], '', $processedContent);
                    }
                @endphp
                {!! $processedContent !!}
            </div>

            @if(isset($page) && $page->pdf_path)
                <div class="mt-8 space-y-6 pt-6 border-t border-border-gray">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-off p-5 border border-border-gray rounded-2xl">
                        <div>
                            <h3 class="font-prompt text-lg font-bold text-navy mb-1">เอกสารแนบประกอบหน้าเพจ</h3>
                            <p class="text-xs text-muted">{{ $title }} (ไฟล์เอกสาร PDF)</p>
                        </div>
                        <a href="{{ asset($page->pdf_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-teal text-white font-prompt text-xs font-semibold py-2.5 px-6 rounded-xl hover:bg-teal-dark shadow-md shadow-teal/10 transition-all">
                            <span>📥</span> ดาวน์โหลดไฟล์ PDF
                        </a>
                    </div>

                    <div class="border border-border-gray rounded-2xl overflow-hidden shadow-lg w-full bg-off">
                        <iframe src="{{ asset($page->pdf_path) }}#view=FitH" style="width: 100%; height: 950px; border: none;" frameborder="0"></iframe>
                    </div>
                </div>
            @endif

            @if(!empty($bottomContent))
                <div class="mt-8 pt-6 border-t border-border-gray">
                    {!! $bottomContent !!}
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
