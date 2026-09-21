<x-public-layout>
    <x-slot name="title">บริการออนไลน์ E-Service</x-slot>

    <!-- ── HEADER BANNER ── -->
    <div class="relative text-white py-12 overflow-hidden" style="background-color: #1E0730;">
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full blur-3xl pointer-events-none" style="background-color: rgba(141, 56, 201, 0.15);"></div>
        <div class="absolute left-12 bottom-12 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background-color: rgba(196, 153, 108, 0.15);"></div>
        
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <h1 class="font-prompt text-3xl font-bold mb-1">
                บริการออนไลน์ (E-Service)
            </h1>
            <p class="text-white/70 font-light text-sm">
                ศูนย์บริการ e-Services แบบครบวงจรสำหรับ นิสิต บุคลากร และบุคคลภายนอก คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    <!-- ── MAIN CONTENT (Interactive Tabs) ── -->
    <div class="max-w-[1200px] mx-auto px-6 py-12" 
         x-data="{ activeTab: (new URLSearchParams(window.location.search)).get('target') || 'student' }">
        
        <!-- Tab Navigation Buttons -->
        <div class="flex border-b border-border-gray mb-10 overflow-x-auto whitespace-nowrap gap-2 md:gap-4 pb-1">
            <button @click="activeTab = 'student'" 
                    class="py-3 px-6 font-prompt font-bold text-sm border-b-2 transition-all cursor-pointer"
                    :class="activeTab === 'student' ? 'border-[#8D38C9] text-[#8D38C9] bg-[#8D38C9]/5 rounded-t-xl' : 'border-transparent text-muted hover:text-navy hover:bg-off rounded-t-xl'">
                🎓 สำหรับนิสิตปัจจุบัน
            </button>
            <button @click="activeTab = 'staff'" 
                    class="py-3 px-6 font-prompt font-bold text-sm border-b-2 transition-all cursor-pointer"
                    :class="activeTab === 'staff' ? 'border-[#8D38C9] text-[#8D38C9] bg-[#8D38C9]/5 rounded-t-xl' : 'border-transparent text-muted hover:text-navy hover:bg-off rounded-t-xl'">
                💼 สำหรับบุคลากร
            </button>
            <button @click="activeTab = 'general'" 
                    class="py-3 px-6 font-prompt font-bold text-sm border-b-2 transition-all cursor-pointer"
                    :class="activeTab === 'general' ? 'border-[#8D38C9] text-[#8D38C9] bg-[#8D38C9]/5 rounded-t-xl' : 'border-transparent text-muted hover:text-navy hover:bg-off rounded-t-xl'">
                🌐 สำหรับบุคคลทั่วไป
            </button>
        </div>

        <!-- ── TAB CONTENT: STUDENT ── -->
        <div x-show="activeTab === 'student'" x-transition:enter="transition ease-out duration-300" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services->filter(fn($sv) => is_array($sv->category) ? in_array('student', $sv->category) : $sv->category === 'student') as $sv)
                    @php
                        $targetUrl = $sv->url;
                        if (!str_starts_with($sv->url, 'http') && !str_starts_with($sv->url, '#') && Route::has($sv->url)) {
                            $targetUrl = route($sv->url);
                        }
                    @endphp
                    <div class="card border border-border-gray p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all flex flex-col justify-between min-h-[190px]">
                        <div>
                            @if($sv->badge_text)
                                <span class="text-xs font-bold text-[#8D38C9] uppercase tracking-wider block mb-1">{{ $sv->badge_text }}</span>
                            @endif
                            <h3 class="font-prompt font-bold text-navy text-sm mb-2">{{ $sv->title }}</h3>
                            <p class="text-xs text-muted font-light mb-4 leading-relaxed">{{ $sv->description }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 pt-4 border-t border-border-gray/50">
                            <a href="{{ $targetUrl }}" target="_blank" 
                               class="inline-flex items-center gap-1.5 font-prompt font-semibold text-[11px] py-2 px-4 rounded-lg transition-all hover:opacity-90" style="background-color: #8D38C9; color: #FFFFFF;">
                                <span>คลิกเข้าใช้งานระบบ ➔</span>
                            </a>
                            @if($sv->manual_url)
                                <a href="{{ $sv->manual_url }}" target="_blank" 
                                   class="inline-flex items-center gap-1 border border-border-gray text-navy font-prompt font-semibold text-[11px] py-2 px-4 rounded-lg hover:bg-off transition-colors">
                                    <span>📖 คู่มือการใช้งาน</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-muted">
                        ไม่มีระบบบริการออนไลน์ E-Service ในหมวดหมู่นี้
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ── TAB CONTENT: STAFF ── -->
        <div x-show="activeTab === 'staff'" x-transition:enter="transition ease-out duration-300" class="space-y-6" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services->filter(fn($sv) => is_array($sv->category) ? in_array('staff', $sv->category) : $sv->category === 'staff') as $sv)
                    @php
                        $targetUrl = $sv->url;
                        if (!str_starts_with($sv->url, 'http') && !str_starts_with($sv->url, '#') && Route::has($sv->url)) {
                            $targetUrl = route($sv->url);
                        }
                    @endphp
                    <div class="card border border-border-gray p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all flex flex-col justify-between min-h-[190px]">
                        <div>
                            @if($sv->badge_text)
                                <span class="text-xs font-bold text-[#8D38C9] uppercase tracking-wider block mb-1">{{ $sv->badge_text }}</span>
                            @endif
                            <h3 class="font-prompt font-bold text-navy text-sm mb-2">{{ $sv->title }}</h3>
                            <p class="text-xs text-muted font-light mb-4 leading-relaxed">{{ $sv->description }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 pt-4 border-t border-border-gray/50">
                            <a href="{{ $targetUrl }}" target="_blank" 
                               class="inline-flex items-center gap-1.5 font-prompt font-semibold text-[11px] py-2 px-4 rounded-lg transition-all hover:opacity-90" style="background-color: #8D38C9; color: #FFFFFF;">
                                <span>คลิกเข้าใช้งานระบบ ➔</span>
                            </a>
                            @if($sv->manual_url)
                                <a href="{{ $sv->manual_url }}" target="_blank" 
                                   class="inline-flex items-center gap-1 border border-border-gray text-navy font-prompt font-semibold text-[11px] py-2 px-4 rounded-lg hover:bg-off transition-colors">
                                    <span>📖 คู่มือการใช้งาน</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-muted">
                        ไม่มีระบบบริการออนไลน์ E-Service ในหมวดหมู่นี้
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ── TAB CONTENT: GENERAL PUBLIC ── -->
        <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" class="space-y-6" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services->filter(fn($sv) => is_array($sv->category) ? in_array('general', $sv->category) : $sv->category === 'general') as $sv)
                    @php
                        $targetUrl = $sv->url;
                        if (!str_starts_with($sv->url, 'http') && !str_starts_with($sv->url, '#') && Route::has($sv->url)) {
                            $targetUrl = route($sv->url);
                        }
                    @endphp
                    <div class="card border border-border-gray p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all flex flex-col justify-between min-h-[190px]">
                        <div>
                            @if($sv->badge_text)
                                <span class="text-xs font-bold text-[#8D38C9] uppercase tracking-wider block mb-1">{{ $sv->badge_text }}</span>
                            @endif
                            <h3 class="font-prompt font-bold text-navy text-sm mb-2">{{ $sv->title }}</h3>
                            <p class="text-xs text-muted font-light mb-4 leading-relaxed">{{ $sv->description }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2 pt-4 border-t border-border-gray/50">
                            <a href="{{ $targetUrl }}" target="_blank" 
                               class="inline-flex items-center gap-1.5 font-prompt font-semibold text-[11px] py-2 px-4 rounded-lg transition-all hover:opacity-90" style="background-color: #8D38C9; color: #FFFFFF;">
                                <span>คลิกเข้าใช้งานระบบ ➔</span>
                            </a>
                            @if($sv->manual_url)
                                <a href="{{ $sv->manual_url }}" target="_blank" 
                                   class="inline-flex items-center gap-1 border border-border-gray text-navy font-prompt font-semibold text-[11px] py-2 px-4 rounded-lg hover:bg-off transition-colors">
                                    <span>📖 คู่มือการใช้งาน</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-muted">
                        ไม่มีระบบบริการออนไลน์ E-Service ในหมวดหมู่นี้
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-public-layout>
