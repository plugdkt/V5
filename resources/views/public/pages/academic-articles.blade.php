<x-public-layout>
    <x-slot name="title">บทความวิชาการและผลงานวิจัย - คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    <!-- ── HEADER BANNER (Scholarly Navy Theme) ── -->
    <div style="background: linear-gradient(135deg, #0B2545 0%, #133C55 50%, #051923 100%); color: #ffffff;" class="relative py-12 px-6 overflow-hidden shadow-xl mb-8">
        <div class="absolute -right-12 -top-12 w-72 h-72 rounded-full blur-3xl pointer-events-none" style="background-color: rgba(251, 191, 36, 0.15);"></div>
        <div class="absolute left-12 bottom-12 w-80 h-80 rounded-full blur-3xl pointer-events-none" style="background-color: rgba(14, 165, 233, 0.15);"></div>
        
        <div class="max-w-[1200px] mx-auto relative z-10">
            <div style="background-color: rgba(251, 191, 36, 0.2); border: 1px solid rgba(251, 191, 36, 0.4); color: #fef08a;" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider mb-4 font-prompt">
                🔬 คลังความรู้ & งานวิจัยตีพิมพ์ · Academic Articles & Research
            </div>
            <h1 style="color: #ffffff;" class="font-prompt text-2xl sm:text-4xl font-bold mb-3 leading-tight">
                บทความวิชาการและผลงานวิจัย<br>
                <span style="color: #fbbf24;">คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</span>
            </h1>
            <p style="color: rgba(255, 255, 255, 0.85);" class="font-light text-xs sm:text-sm max-w-3xl leading-relaxed font-prompt">
                รวบรวมผลงานวิจัยตีพิมพ์ในวารสารระดับชาติและนานาชาติ (PubMed, Scopus, TCI) บทความวิทยาทาน และงานสร้างสรรค์ทางวิทยาศาสตร์การแพทย์ โดยคณาจารย์และนักวิจัย คณะวิทยาศาสตร์การแพทย์
            </p>
        </div>
    </div>

    <!-- ── MAIN CONTENT AREA ── -->
    <div class="max-w-[1200px] mx-auto px-6 py-4 pb-16">
        <div x-data="{ 
            activeTab: 'all',
            searchQuery: ''
        }" style="color: #1E293B;">
            
            <!-- Top Filter Controls Bar -->
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-8">
                
                <!-- Division Category Pills -->
                <div class="flex flex-wrap gap-2 pb-1 flex-1 font-prompt">
                    <button @click="activeTab = 'all'" 
                            class="py-2 px-4 rounded-xl text-xs font-semibold transition-all cursor-pointer border"
                            :class="activeTab === 'all' ? 'bg-[#0B2545] text-white border-[#0B2545] shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                        🌟 ทั้งหมด (All)
                    </button>
                    <button @click="activeTab = 'biochemistry'" 
                            class="py-2 px-4 rounded-xl text-xs font-semibold transition-all cursor-pointer border"
                            :class="activeTab === 'biochemistry' ? 'bg-[#0B2545] text-white border-[#0B2545] shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                        🧬 ชีวเคมี
                    </button>
                    <button @click="activeTab = 'microbiology'" 
                            class="py-2 px-4 rounded-xl text-xs font-semibold transition-all cursor-pointer border"
                            :class="activeTab === 'microbiology' ? 'bg-[#0B2545] text-white border-[#0B2545] shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                        🔬 จุลชีววิทยา
                    </button>
                    <button @click="activeTab = 'nutrition'" 
                            class="py-2 px-4 rounded-xl text-xs font-semibold transition-all cursor-pointer border"
                            :class="activeTab === 'nutrition' ? 'bg-[#0B2545] text-white border-[#0B2545] shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                        🥗 โภชนาการฯ
                    </button>
                    <button @click="activeTab = 'physiology'" 
                            class="py-2 px-4 rounded-xl text-xs font-semibold transition-all cursor-pointer border"
                            :class="activeTab === 'physiology' ? 'bg-[#0B2545] text-white border-[#0B2545] shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                        ⚡ สรีรวิทยา
                    </button>
                    <button @click="activeTab = 'anatomy'" 
                            class="py-2 px-4 rounded-xl text-xs font-semibold transition-all cursor-pointer border"
                            :class="activeTab === 'anatomy' ? 'bg-[#0B2545] text-white border-[#0B2545] shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                        🦴 กายวิภาคศาสตร์
                    </button>
                </div>

                <!-- Live Search Box -->
                <div class="relative flex-shrink-0" style="width: 240px; min-width: 240px;">
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="🔍 ค้นหาบทความ / ผู้เขียน..." 
                           style="width: 240px; color: #0F172A;"
                           class="pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-prompt focus:outline-none focus:border-[#0B2545] focus:bg-white transition-all shadow-sm">
                </div>
            </div>

            <!-- Article Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if(count($articles) > 0)
                    @foreach($articles as $item)
                        @php
                            $searchText = mb_strtolower($item->title . ' ' . ($item->author ?? '') . ' ' . ($item->division ?? ''));
                        @endphp
                        <div x-show="(activeTab === 'all' || activeTab === '{{ $item->category }}') && (searchQuery === '' || $el.dataset.search.includes(searchQuery.toLowerCase().trim()))"
                             data-search="{{ $searchText }}"
                             x-transition
                             style="background-color: #FFFFFF; color: #1E293B; border: 1px solid #E2E8F0;" 
                             class="rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col justify-between min-h-[220px]">
                            <div>
                                <!-- Badge & Date -->
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span style="color: #0284C7;" class="text-xs font-bold uppercase tracking-wider block font-prompt">
                                        {{ $item->badge }}
                                    </span>
                                    @if($item->published_at)
                                        <span style="background-color: #F1F5F9; color: #475569;" class="text-[10px] px-2.5 py-0.5 rounded-full font-prompt">
                                            {{ $item->published_at->format('Y-m-d') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Article Title -->
                                <h3 style="color: #0B2545;" class="font-prompt font-bold text-sm sm:text-base mb-3 leading-snug hover:text-sky-700 transition-colors">
                                    {{ $item->title }}
                                </h3>

                                <!-- Author Info -->
                                @if($item->author)
                                    <div style="color: #334155;" class="flex items-center gap-2 text-xs mb-4 font-prompt">
                                        <span style="background-color: #EFF6FF; color: #1D4ED8;" class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">👤</span>
                                        <span class="font-medium">{{ $item->author }}</span>
                                    </div>
                                @endif

                                <!-- Abstract preview if available -->
                                @if($item->abstract)
                                    <p style="color: #475569; background-color: #F8FAFC; border: 1px solid #F1F5F9;" class="text-xs font-light line-clamp-3 mb-4 leading-relaxed p-3 rounded-xl font-prompt">
                                        {{ $item->abstract }}
                                    </p>
                                @endif
                            </div>

                            <!-- Actions Bar -->
                            <div style="border-top: 1px solid #F1F5F9;" class="flex flex-wrap items-center justify-between gap-2 pt-4">
                                <span style="color: #64748B;" class="text-[11px] font-prompt">{{ $item->division }}</span>

                                @if($item->link_url)
                                    <a href="{{ $item->link_url }}" 
                                       target="_blank" 
                                       rel="noopener"
                                       style="background-color: #0B2545; color: #FFFFFF;"
                                       class="inline-flex items-center gap-1.5 font-prompt font-semibold text-[11px] py-2 px-4 rounded-xl transition-all hover:bg-[#133C55] shadow-sm">
                                        <span>🔗 อ่านบทความ / ผลงานฉบับเต็ม ➔</span>
                                    </a>
                                @else
                                    <span style="color: #64748B; background-color: #F8FAFC;" class="inline-flex items-center gap-1 font-prompt text-[11px] py-2 px-3 rounded-lg border border-slate-100">
                                        📄 เผยแพร่ในรูปเล่มวิชาการ
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 text-center py-12 text-gray-500 font-prompt">
                        ยังไม่มีข้อมูลบทความวิชาการในระบบ
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-public-layout>
