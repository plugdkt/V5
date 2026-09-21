<div>
    {{-- Search & Category Filter bar --}}
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-6 mb-8 items-center">
        {{-- Categories list --}}
        <div class="flex flex-wrap gap-2">
            <button wire:click="selectCategory('')" 
                    class="badge text-xs px-3.5 py-2 rounded-full border transition-all cursor-pointer {{ empty($categorySlug) ? 'bg-navy text-white border-navy font-bold' : 'bg-white text-navy border-border-gray hover:bg-off' }}">
                ทั้งหมด
            </button>
            @foreach($categories as $cat)
                <button wire:click="selectCategory('{{ $cat->slug }}')" 
                        class="badge text-xs px-3.5 py-2 rounded-full border transition-all cursor-pointer"
                        style="{{ $categorySlug === $cat->slug ? 'background-color: ' . $cat->color . '; color: white; border-color: ' . $cat->color . '; font-weight: bold;' : 'background-color: white; color: ' . $cat->color . '; border-color: ' . $cat->color . '30;' }} hover:bg-off">
                    {{ $cat->name_th }}
                </button>
            @endforeach
        </div>

        {{-- Search input --}}
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input pr-10" placeholder="🔍 ค้นหาข่าวสาร...">
            @if($search)
                <button wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted hover:text-navy text-sm">✕</button>
            @endif
        </div>
    </div>

    {{-- Active tag/search notice --}}
    @if($search || $categorySlug || $tagSlug)
        <div class="bg-off border border-border-gray rounded-xl p-4 mb-8 flex justify-between items-center text-xs text-navy flex-wrap gap-2">
            <div class="flex items-center gap-1.5 flex-wrap">
                <span>กรองโดย:</span>
                @if($categorySlug)
                    <span class="bg-white border border-border-gray px-2.5 py-1 rounded-lg">หมวดหมู่: {{ $categories->where('slug', $categorySlug)->first()->name_th }}</span>
                @endif
                @if($tagSlug)
                    <span class="bg-white border border-border-gray px-2.5 py-1 rounded-lg">แท็ก: #{{ $tagSlug }}</span>
                @endif
                @if($search)
                    <span class="bg-white border border-border-gray px-2.5 py-1 rounded-lg">ค้นหา: "{{ $search }}"</span>
                @endif
            </div>
            <button wire:click="clearFilters" class="text-red-600 font-bold hover:underline cursor-pointer">ล้างตัวกรองทั้งหมด ✕</button>
        </div>
    @endif

    {{-- News Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($news as $article)
            <a href="{{ route('news.show', $article->slug) }}" class="card card-hover flex flex-col overflow-hidden h-full group border border-border-gray">
                <div class="h-48 bg-gradient-to-br from-navy to-teal relative overflow-hidden flex-shrink-0">
                    @if($article->cover_image)
                        <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title_th }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white/10 text-7xl font-prompt font-bold">M</div>
                    @endif
                    <div class="absolute bottom-4 left-4">
                        <span class="text-[9px] font-bold text-white px-2 py-0.5 rounded" style="background-color: {{ $article->category->color }}">
                            {{ $article->category->name_th }}
                        </span>
                    </div>
                </div>
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="font-prompt text-base font-bold text-navy mb-2 line-clamp-2 group-hover:text-teal transition-colors">
                            {{ $article->title_th }}
                        </h3>
                        <p class="text-xs text-muted line-clamp-3 mb-4 font-light">
                            {{ $article->excerpt }}
                        </p>
                    </div>
                    <div class="text-[10px] text-muted flex items-center justify-between border-t border-border-gray pt-3 mt-3">
                        <span>📅 {{ $article->published_at->locale('th')->translatedFormat('d M y') }}</span>
                        <span>👁️ {{ $article->view_count }} Views</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full card p-16 text-center text-muted border border-border-gray">
                📭 ไม่พบข่าวประชาสัมพันธ์ที่ค้นหา
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-12">
        {{ $news->links() }}
    </div>
</div>
