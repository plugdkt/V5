<x-admin-layout>
    <x-slot name="title">แดชบอร์ดภาพรวม & สถิติผู้เข้าชมเว็บไซต์</x-slot>

    {{-- Top Welcome & External Systems Hub --}}
    <div class="rounded-2xl p-4 sm:p-5 mb-5 shadow-md flex flex-col md:flex-row md:items-center justify-between gap-3 border border-blue-900/30" 
         style="background: linear-gradient(135deg, #07192E 0%, #0B2545 60%, #152E4D 100%); color: #FFFFFF;">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="text-xl">📊</span>
                <h2 class="text-base md:text-lg font-bold font-prompt text-white tracking-wide" style="color: #FFFFFF;">
                    ภาพรวมระบบ MedSci UP CMS (V5)
                </h2>
                <span class="text-[11px] px-2.5 py-0.5 rounded-full font-medium" 
                      style="background: rgba(255, 255, 255, 0.16); color: #F1F5F9; border: 1px solid rgba(255, 255, 255, 0.25);">
                    {{ now()->locale('th')->translatedFormat('lที่ j F Y') }}
                </span>
            </div>
            <p class="text-xs font-light" style="color: #CBD5E1;">
                ระบบตรวจจับสถิติการเข้าชมหน้า/เมนูเว็บไซต์ เพื่อติดตามความนิยมและนำข้อมูลไปพัฒนาเว็บไซต์ต่อไป
            </p>
        </div>

        {{-- External Portals --}}
        <div class="flex flex-wrap items-center gap-2 pt-1 md:pt-0">
            <a href="https://www.medsci.up.ac.th/mtr_booking/sso_callback.php" target="_blank" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all shadow-sm hover:brightness-110"
               style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); color: #FFFFFF;">
                <span>🚪</span>
                <span>ระบบจองห้องประชุม</span>
                <span class="text-[10px]" style="color: #94A3B8;">↗</span>
            </a>
            <a href="https://www.medsci.up.ac.th/msc_news/index.php" target="_blank" 
               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all shadow-sm hover:brightness-110"
               style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); color: #FFFFFF;">
                <span>📰</span>
                <span>ระบบข่าวสาร (MSC News)</span>
                <span class="text-[10px]" style="color: #94A3B8;">↗</span>
            </a>
        </div>
    </div>

    {{-- Quick Actions & System Status Bar --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-5 p-3.5 bg-white rounded-2xl border border-gray-200 shadow-xs">
        {{-- Quick Actions --}}
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mr-1 flex items-center gap-1">
                <span>⚡</span> ทางลัด:
            </span>
            <a href="{{ route('admin.policies.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#8D38C9] bg-purple-50 hover:bg-purple-100 transition-colors border border-purple-100">
                <span>➕</span> แผน/นโยบาย
            </a>
            <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-colors border border-indigo-100">
                <span>➕</span> รายงาน
            </a>
            <a href="{{ route('admin.downloads.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors border border-emerald-100">
                <span>📄</span> จัดการไฟล์
            </a>
            <a href="{{ route('admin.slides.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 transition-colors border border-amber-100">
                <span>🖼️</span> สไลด์หน้าแรก
            </a>
            <a href="{{ route('admin.media.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 transition-colors border border-sky-100">
                <span>📁</span> คลังสื่อ
            </a>
        </div>

        {{-- System Health & Storage Info --}}
        <div class="flex flex-wrap items-center gap-2 pt-2 lg:pt-0 border-t lg:border-t-0 border-gray-100 text-xs">
            {{-- Storage Usage --}}
            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 font-medium" title="พื้นที่จัดเก็บสื่อและเอกสารในโฟลเดอร์ storage/app/public">
                <span>💾</span>
                <span>พื้นที่สื่อ: <strong class="text-gray-900 font-bold font-prompt">{{ $storageSizeMB > 1024 ? number_format($storageSizeMB / 1024, 2) . ' GB' : number_format($storageSizeMB, 1) . ' MB' }}</strong></span>
            </div>

            {{-- Health Status Pill --}}
            @if(count($healthIssues) === 0)
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-semibold" title="ไฟล์เอกสารและสไลด์ทั้งหมดพร้อมใช้งาน">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>ระบบสมบูรณ์ 100%</span>
                </div>
            @else
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 font-semibold" title="{{ implode(', ', $healthIssues) }}">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>พบ {{ count($healthIssues) }} จุดต้องตรวจ</span>
                </div>
            @endif
        </div>
    </div>

    {{-- System Health Alert Bar (Only shown when there are issues) --}}
    @if(count($healthIssues) > 0)
    <div class="mb-5 p-3 px-4 rounded-2xl bg-amber-50/90 border border-amber-200/90 text-amber-900 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-2 shadow-xs">
        <div class="flex items-center gap-2.5">
            <span class="text-base">⚠️</span>
            <div>
                <strong class="font-prompt text-amber-950">ข้อแนะนำในการดูแลความสมบูรณ์ของเว็บไซต์:</strong>
                <span class="ml-1 text-amber-800">{{ implode(' • ', $healthIssues) }}</span>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            @if($policyMissingFiles > 0)
                <a href="{{ route('admin.policies.index') }}" class="px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-amber-900 hover:bg-amber-100 font-semibold transition-colors text-[11px]">ตรวจนโยบาย →</a>
            @endif
            @if($reportMissingFiles > 0)
                <a href="{{ route('admin.reports.index') }}" class="px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-amber-900 hover:bg-amber-100 font-semibold transition-colors text-[11px]">ตรวจรายงาน →</a>
            @endif
            @if($activeSlidesCount === 0)
                <a href="{{ route('admin.slides.index') }}" class="px-2.5 py-1 rounded-lg bg-white border border-amber-300 text-amber-900 hover:bg-amber-100 font-semibold transition-colors text-[11px]">เพิ่มสไลด์ →</a>
            @endif
        </div>
    </div>
    @endif

    {{-- 4 KPI Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Card 1: Page Views Today --}}
        <div class="bg-white rounded-2xl p-4 border border-gray-200 flex flex-col justify-between shadow-sm hover:shadow transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 block mb-0.5">ยอดเข้าชมหน้าเว็บวันนี้</span>
                    <span class="font-prompt text-2xl lg:text-3xl font-bold text-[#0B2545]">{{ number_format($todayViews) }}</span>
                    <span class="text-[11px] text-gray-400 font-light ml-1">ครั้ง</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold shadow-inner">
                    👁️
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500">
                <span>7 วัน: <strong class="text-gray-800 font-semibold">{{ number_format($weekViews) }}</strong></span>
                <span>30 วัน: <strong class="text-gray-800 font-semibold">{{ number_format($monthViews) }}</strong></span>
            </div>
        </div>

        {{-- Card 2: Policies & Reports --}}
        <div class="bg-white rounded-2xl p-4 border border-gray-200 flex flex-col justify-between shadow-sm hover:shadow transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 block mb-0.5">แผน นโยบาย & รายงาน</span>
                    <span class="font-prompt text-2xl lg:text-3xl font-bold text-[#8D38C9]">{{ number_format($policiesCount + $reportsCount) }}</span>
                    <span class="text-[11px] text-gray-400 font-light ml-1">ฉบับ</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-[#8D38C9] flex items-center justify-center text-lg font-bold shadow-inner">
                    📁
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-100 flex items-center justify-between text-[11px]">
                <a href="{{ route('admin.policies.index') }}" class="text-[#8D38C9] hover:underline font-medium">แผน/นโยบาย ({{ $policiesCount }})</a>
                <a href="{{ route('admin.reports.index') }}" class="text-[#8D38C9] hover:underline font-medium">รายงาน ({{ $reportsCount }})</a>
            </div>
        </div>

        {{-- Card 3: Downloadable Files --}}
        <div class="bg-white rounded-2xl p-4 border border-gray-200 flex flex-col justify-between shadow-sm hover:shadow transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 block mb-0.5">ไฟล์ดาวน์โหลด & แบบฟอร์ม</span>
                    <span class="font-prompt text-2xl lg:text-3xl font-bold text-emerald-700">{{ number_format($downloadsCount) }}</span>
                    <span class="text-[11px] text-gray-400 font-light ml-1">ไฟล์</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold shadow-inner">
                    📄
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-100 flex items-center justify-between text-[11px]">
                <span class="text-gray-500">สถานะ: เปิดให้บริการ</span>
                <a href="{{ route('admin.downloads.index') }}" class="text-emerald-700 hover:underline font-semibold">จัดการไฟล์ →</a>
            </div>
        </div>

        {{-- Card 4: Active Slides & Programs --}}
        <div class="bg-white rounded-2xl p-4 border border-gray-200 flex flex-col justify-between shadow-sm hover:shadow transition-all">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-xs font-semibold text-gray-500 block mb-0.5">สไลด์หน้าแรก & หลักสูตร</span>
                    <span class="font-prompt text-2xl lg:text-3xl font-bold text-amber-700">{{ number_format($activeSlidesCount) }}</span>
                    <span class="text-[11px] text-gray-400 font-light ml-1">สไลด์เปิดอยู่</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold shadow-inner">
                    🖼️
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-gray-100 flex items-center justify-between text-[11px]">
                <a href="{{ route('admin.slides.index') }}" class="text-amber-700 hover:underline font-medium">จัดการสไลด์ →</a>
                <a href="{{ route('admin.programs.index') }}" class="text-gray-600 hover:underline">หลักสูตร ({{ $programsCount }})</a>
            </div>
        </div>
    </div>

    {{-- Main Analytics Section (2 Equal Columns: Top Pages Table + Daily Trend & Devices) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Left Box: Top 10 Most Visited Pages (Col 1) --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-3.5 border-b border-gray-100 mb-3">
                    <div>
                        <h3 class="font-prompt text-sm sm:text-base font-bold text-[#0B2545] flex items-center gap-1.5">
                            <span>🏆</span>
                            <span>10 อันดับ หน้า / เมนูยอดนิยม</span>
                        </h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">ไม่รวมหน้าแรก • แสดงแนวโน้มการเปลี่ยนแปลงอันดับเทียบช่วงก่อนหน้า</p>
                    </div>

                    {{-- Time Range Switcher --}}
                    <div class="inline-flex bg-gray-100 p-1 rounded-xl text-xs font-medium self-start sm:self-auto">
                        <a href="{{ route('admin.dashboard', ['range' => '7']) }}" 
                           class="px-3 py-1 rounded-lg transition-all {{ $range === '7' ? 'bg-white text-[#0B2545] font-bold shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                            7 วัน
                        </a>
                        <a href="{{ route('admin.dashboard', ['range' => '30']) }}" 
                           class="px-3 py-1 rounded-lg transition-all {{ $range === '30' ? 'bg-white text-[#0B2545] font-bold shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                            30 วัน
                        </a>
                        <a href="{{ route('admin.dashboard', ['range' => 'all']) }}" 
                           class="px-3 py-1 rounded-lg transition-all {{ $range === 'all' ? 'bg-white text-[#0B2545] font-bold shadow-xs' : 'text-gray-500 hover:text-gray-800' }}">
                            ทั้งหมด
                        </a>
                    </div>
                </div>

                {{-- Table list --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-gray-400 border-b border-gray-100 font-semibold uppercase text-[10px] tracking-wider">
                                <th class="pb-2 w-20 text-center">อันดับ</th>
                                <th class="pb-2">หน้าเว็บ / เมนู</th>
                                <th class="pb-2 w-20 text-right">ครั้ง (วิว)</th>
                                <th class="pb-2 w-28 pl-3 hidden md:table-cell">สัดส่วน</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($topPages as $index => $page)
                                @php
                                    $percent = $maxViews > 0 ? round(($page->total_views / $maxViews) * 100) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="py-2.5 text-center">
                                        <div class="inline-flex items-center justify-center gap-1.5">
                                            {{-- Rank Number or Medal --}}
                                            @if($index === 0)
                                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-100 text-amber-800 font-bold text-[11px] flex-shrink-0 shadow-2xs">🥇</span>
                                            @elseif($index === 1)
                                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-slate-100 text-slate-700 font-bold text-[11px] flex-shrink-0 shadow-2xs">🥈</span>
                                            @elseif($index === 2)
                                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-50 text-amber-700 font-bold text-[11px] flex-shrink-0 shadow-2xs">🥉</span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gray-100 text-gray-500 font-semibold text-[10px] flex-shrink-0">{{ $index + 1 }}</span>
                                            @endif

                                            {{-- Rank Trend Indicator with Explicit Inline Colors --}}
                                            @if($page->rank_change === 'new')
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9px] font-bold leading-none shadow-2xs" 
                                                      style="color: #D97706; background-color: #FFFBEB; border: 1px solid #FDE68A;" 
                                                      title="เพิ่งขึ้นมาติดอันดับสัปดาห์นี้">
                                                    NEW
                                                </span>
                                            @elseif($page->rank_change > 0)
                                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-bold font-mono leading-none shadow-2xs" 
                                                      style="color: #059669; background-color: #ECFDF5; border: 1px solid #A7F3D0;" 
                                                      title="ขึ้น {{ $page->rank_change }} อันดับ (เดิมอันดับ #{{ $page->prev_rank }})">
                                                    <span>▲</span><span>{{ $page->rank_change }}</span>
                                                </span>
                                            @elseif($page->rank_change < 0)
                                                <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-bold font-mono leading-none shadow-2xs" 
                                                      style="color: #DC2626; background-color: #FEF2F2; border: 1px solid #FECACA;" 
                                                      title="ลง {{ abs($page->rank_change) }} อันดับ (เดิมอันดับ #{{ $page->prev_rank }})">
                                                    <span>▼</span><span>{{ abs($page->rank_change) }}</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-5 py-0.5 rounded text-[10px] font-bold font-mono leading-none" 
                                                      style="color: #94A3B8; background-color: #F8FAFC; border: 1px solid #E2E8F0;" 
                                                      title="อันดับคงที่">
                                                    −
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-2.5 pr-2">
                                        <div class="font-bold text-[#0B2545] text-xs flex items-center gap-1.5">
                                            <span class="truncate max-w-[170px] sm:max-w-[220px] xl:max-w-xs" title="{{ $page->page_title ?: $page->path }}">{{ $page->page_title ?: $page->path }}</span>
                                            <a href="{{ url($page->path) }}" target="_blank" class="text-gray-300 hover:text-teal transition-colors flex-shrink-0" title="เปิดดูหน้านี้">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            </a>
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-mono mt-0.5 truncate max-w-[170px] sm:max-w-[220px] xl:max-w-xs">{{ $page->path }}</div>
                                    </td>
                                    <td class="py-2.5 text-right font-prompt font-bold text-gray-800 text-xs">
                                        {{ number_format($page->total_views) }}
                                    </td>
                                    <td class="py-2.5 pl-3 hidden md:table-cell">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                                <div class="h-1.5 rounded-full" style="width: {{ $percent }}%; background: linear-gradient(90deg, #3B82F6 0%, #8D38C9 100%);"></div>
                                            </div>
                                            <span class="text-[10px] text-gray-400 font-mono w-7 text-right">{{ $percent }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400">ยังไม่มีข้อมูลสถิติการเข้าชมในช่วงเวลานี้</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-3 pt-2.5 border-t border-gray-100 text-[11px] text-gray-400 flex flex-wrap items-center justify-between gap-2">
                <span class="inline-flex flex-wrap items-center gap-1.5">
                    <span>💡</span>
                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-bold" style="color: #059669; background-color: #ECFDF5; border: 1px solid #A7F3D0;">▲ ขยับขึ้น</span>
                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-[10px] font-bold" style="color: #DC2626; background-color: #FEF2F2; border: 1px solid #FECACA;">▼ ขยับลง</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold" style="color: #94A3B8; background-color: #F8FAFC; border: 1px solid #E2E8F0;">− คงที่</span>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold" style="color: #D97706; background-color: #FFFBEB; border: 1px solid #FDE68A;">NEW มาใหม่</span>
                    <span class="text-gray-400 text-[10px] ml-1">(เทียบช่วงก่อนหน้า)</span>
                </span>
                <span>รวม 10 อันดับ: <strong class="text-gray-700 font-bold">{{ number_format($topPages->sum('total_views')) }}</strong> ครั้ง</span>
            </div>
        </div>

        {{-- Right: Daily Trend Chart & Device Breakdown (Col 2) --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-2">
                    <div>
                        <h3 class="font-prompt text-sm sm:text-base font-bold text-[#0B2545] flex items-center gap-1.5">
                            <span>📈</span>
                            <span>แนวโน้มผู้เข้าชม (14 วันล่าสุด)</span>
                        </h3>
                        <p class="text-[11px] text-gray-400 mt-0.5">จำนวนครั้งที่เปิดดูในแต่ละวัน</p>
                    </div>
                </div>

                {{-- Chart Canvas --}}
                <div class="relative h-52 sm:h-56 lg:h-[215px] w-full">
                    <canvas id="dailyViewsChart"></canvas>
                </div>

                {{-- Stacked Analytics: Device Power Bar + Time of Day Power Bar --}}
                <div class="mt-4 pt-3.5 border-t border-gray-100 space-y-3">
                    {{-- 1. Device Share Power Bar --}}
                    <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-200/70 shadow-2xs">
                        <div class="flex items-center justify-between mb-1.5">
                            <h4 class="font-prompt text-xs font-bold text-[#0B2545] flex items-center gap-1.5">
                                <span>📱</span>
                                <span>สัดส่วนอุปกรณ์ (Device Share)</span>
                            </h4>
                            <span class="text-[10px] text-gray-400 font-light">
                                รวม {{ number_format($deviceTotal) }} ครั้ง
                            </span>
                        </div>

                        {{-- Power Bar for Devices --}}
                        <div class="w-full bg-gray-200/80 rounded-full h-3 flex overflow-hidden p-0.5 gap-0.5 shadow-inner">
                            @if($mobilePercent > 0)
                                <div style="width: {{ $mobilePercent }}%; background-color: #3B82F6;" 
                                     class="h-full rounded-full transition-all duration-500 hover:brightness-110" 
                                     title="สมาร์ตโฟน: {{ $mobilePercent }}% ({{ number_format($mobileViews) }} ครั้ง)"></div>
                            @endif
                            @if($desktopPercent > 0)
                                <div style="width: {{ $desktopPercent }}%; background-color: #8D38C9;" 
                                     class="h-full rounded-full transition-all duration-500 hover:brightness-110" 
                                     title="คอมพิวเตอร์: {{ $desktopPercent }}% ({{ number_format($desktopViews) }} ครั้ง)"></div>
                            @endif
                            @if($tabletPercent > 0)
                                <div style="width: {{ $tabletPercent }}%; background-color: #F59E0B;" 
                                     class="h-full rounded-full transition-all duration-500 hover:brightness-110" 
                                     title="แท็บเล็ต: {{ $tabletPercent }}% ({{ number_format($tabletViews) }} ครั้ง)"></div>
                            @endif
                            @if($deviceTotal == 0)
                                <div style="width: 100%; background-color: #CBD5E1;" class="h-full rounded-full" title="ยังไม่มีข้อมูล"></div>
                            @endif
                        </div>

                        {{-- Device Legend --}}
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-[11px]">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #3B82F6;"></span>
                                <span class="text-gray-600">📱 สมาร์ตโฟน:</span>
                                <strong class="text-[#0B2545] font-prompt">{{ $mobilePercent }}%</strong>
                                <span class="text-[10px] text-gray-400 font-normal">({{ number_format($mobileViews) }} ครั้ง)</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #8D38C9;"></span>
                                <span class="text-gray-600">💻 คอมพิวเตอร์:</span>
                                <strong class="text-[#0B2545] font-prompt">{{ $desktopPercent }}%</strong>
                                <span class="text-[10px] text-gray-400 font-normal">({{ number_format($desktopViews) }} ครั้ง)</span>
                            </div>
                            @if($tabletViews > 0)
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #F59E0B;"></span>
                                <span class="text-gray-600">📟 แท็บเล็ต:</span>
                                <strong class="text-[#0B2545] font-prompt">{{ $tabletPercent }}%</strong>
                                <span class="text-[10px] text-gray-400 font-normal">({{ number_format($tabletViews) }} ครั้ง)</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- 2. Time of Day Power Bar (ช่วงเวลาเข้าชม) --}}
                    <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-200/70 shadow-2xs">
                        <div class="flex items-center justify-between mb-1.5">
                            <h4 class="font-prompt text-xs font-bold text-[#0B2545] flex items-center gap-1.5">
                                <span>⏰</span>
                                <span>ช่วงเวลาเข้าชม (Time of Day)</span>
                            </h4>
                            <span class="text-[10px] px-2 py-0.5 rounded-md font-bold text-amber-800 bg-amber-100 border border-amber-200/60 shadow-2xs" title="{{ $peakPeriod }}">
                                🔥 {{ $peakPeriod }}
                            </span>
                        </div>

                        {{-- Power Bar for Time Buckets --}}
                        <div class="w-full bg-gray-200/80 rounded-full h-3 flex overflow-hidden p-0.5 gap-0.5 shadow-inner">
                            @if($morningPercent > 0)
                                <div style="width: {{ $morningPercent }}%; background-color: #F59E0B;" 
                                     class="h-full rounded-full transition-all duration-500 hover:brightness-110" 
                                     title="ช่วงเช้า (06-12 น.): {{ $morningPercent }}% ({{ number_format($viewsMorning) }} ครั้ง)"></div>
                            @endif
                            @if($afternoonPercent > 0)
                                <div style="width: {{ $afternoonPercent }}%; background-color: #0EA5E9;" 
                                     class="h-full rounded-full transition-all duration-500 hover:brightness-110" 
                                     title="ช่วงบ่าย (12-17 น.): {{ $afternoonPercent }}% ({{ number_format($viewsAfternoon) }} ครั้ง)"></div>
                            @endif
                            @if($eveningPercent > 0)
                                <div style="width: {{ $eveningPercent }}%; background-color: #6366F1;" 
                                     class="h-full rounded-full transition-all duration-500 hover:brightness-110" 
                                     title="ช่วงเย็น (17-21 น.): {{ $eveningPercent }}% ({{ number_format($viewsEvening) }} ครั้ง)"></div>
                            @endif
                            @if($nightPercent > 0)
                                <div style="width: {{ $nightPercent }}%; background-color: #64748B;" 
                                     class="h-full rounded-full transition-all duration-500 hover:brightness-110" 
                                     title="ช่วงค่ำ/ดึก (21-06 น.): {{ $nightPercent }}% ({{ number_format($viewsNight) }} ครั้ง)"></div>
                            @endif
                            @if($timeTotal == 0)
                                <div style="width: 100%; background-color: #CBD5E1;" class="h-full rounded-full" title="ยังไม่มีข้อมูล"></div>
                            @endif
                        </div>

                        {{-- Time of Day Legend (4 Columns) --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-2 text-[11px]">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #F59E0B;"></span>
                                <div class="truncate">
                                    <span class="text-gray-600">🌅 เช้า <span class="text-[10px] text-gray-400 font-mono">(06-12)</span>:</span>
                                    <strong class="text-[#0B2545] font-prompt">{{ $morningPercent }}%</strong>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #0EA5E9;"></span>
                                <div class="truncate">
                                    <span class="text-gray-600">☀️ บ่าย <span class="text-[10px] text-gray-400 font-mono">(12-17)</span>:</span>
                                    <strong class="text-[#0B2545] font-prompt">{{ $afternoonPercent }}%</strong>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #6366F1;"></span>
                                <div class="truncate">
                                    <span class="text-gray-600">🌆 เย็น <span class="text-[10px] text-gray-400 font-mono">(17-21)</span>:</span>
                                    <strong class="text-[#0B2545] font-prompt">{{ $eveningPercent }}%</strong>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: #64748B;"></span>
                                <div class="truncate">
                                    <span class="text-gray-600">🌙 ดึก <span class="text-[10px] text-gray-400 font-mono">(21-06)</span>:</span>
                                    <strong class="text-[#0B2545] font-prompt">{{ $nightPercent }}%</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-500 flex flex-wrap items-center justify-between gap-2">
                <span>สัปดาห์นี้: <strong class="text-blue-600 font-bold">{{ number_format($weekViews) }}</strong></span>
                <span>30 วัน: <strong class="text-purple-600 font-bold">{{ number_format($monthViews) }}</strong></span>
                <span>เฉลี่ย/วัน: <strong class="text-gray-800 font-bold">{{ number_format(round($weekViews / 7)) }}</strong></span>
            </div>
        </div>
    </div>

    {{-- Bottom Row: Top Downloads & Recent Updates --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Downloaded Files --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-3">
                <h3 class="font-prompt text-sm font-bold text-[#0B2545] flex items-center gap-2">
                    <span>📥</span>
                    <span>5 อันดับไฟล์ดาวน์โหลด / แบบฟอร์มยอดนิยม</span>
                </h3>
                <a href="{{ route('admin.downloads.index') }}" class="text-xs font-bold text-teal hover:underline">ดูไฟล์ทั้งหมด →</a>
            </div>

            <div class="space-y-2.5">
                @forelse($topDownloads as $file)
                    <div class="flex items-center justify-between gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="min-w-0">
                            <h4 class="font-bold text-xs text-[#0B2545] truncate">{{ $file->title }}</h4>
                            <div class="flex items-center gap-2 text-[10px] text-gray-400 mt-0.5">
                                <span>📁 {{ $file->category->name ?? 'ทั่วไป' }}</span>
                                <span>•</span>
                                <span>ขนาด: {{ round($file->size / 1024, 1) }} KB</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                ⬇️ {{ number_format($file->download_count) }} ครั้ง
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-6 text-xs">ยังไม่มีข้อมูลยอดดาวน์โหลดไฟล์</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Policies & Reports Updates --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-3">
                <h3 class="font-prompt text-sm font-bold text-[#0B2545] flex items-center gap-2">
                    <span>🕒</span>
                    <span>เอกสารแผน / นโยบาย / รายงาน ที่เพิ่งอัปเดตล่าสุด</span>
                </h3>
                <div class="flex gap-2 text-xs font-bold">
                    <a href="{{ route('admin.policies.index') }}" class="text-[#8D38C9] hover:underline">แผน/นโยบาย</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('admin.reports.index') }}" class="text-[#8D38C9] hover:underline">รายงาน</a>
                </div>
            </div>

            <div class="space-y-3">
                @php
                    $allRecent = $recentPolicies->concat($recentReports)->sortByDesc('updated_at')->take(5);
                @endphp
                @forelse($allRecent as $doc)
                    <div class="flex items-center justify-between gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] px-1.5 py-0.5 rounded font-medium {{ $doc instanceof \App\Models\PolicyDocument ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $doc instanceof \App\Models\PolicyDocument ? 'แผน/นโยบาย' : 'รายงานผล' }}
                                </span>
                                <h4 class="font-bold text-xs text-[#0B2545] truncate">{{ $doc->title }}</h4>
                            </div>
                            <div class="flex items-center gap-2 text-[10px] text-gray-400 mt-1">
                                <span>หมวด: {{ $doc->category->name ?? '-' }}</span>
                                @if($doc->group_name)
                                    <span>•</span>
                                    <span>กลุ่ม: {{ $doc->group_name }}</span>
                                @endif
                                <span>•</span>
                                <span>อัปเดต: {{ $doc->updated_at ? $doc->updated_at->locale('th')->diffForHumans() : '-' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if($doc->file_path)
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="p-1 text-gray-400 hover:text-teal" title="ดูไฟล์ PDF">
                                    📄
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-6 text-xs">ไม่มีรายการเอกสารที่เพิ่งอัปเดต</div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Chart.js CDN for interactive trend chart --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dailyViewsChart');
            if (!ctx) return;

            const labels = @json($chartDays);
            const totalViews = @json($chartViews);
            const desktopViews = @json($chartDesktopViews);
            const mobileViews = @json($chartMobileViews);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'รวมทั้งหมด',
                            data: totalViews,
                            borderColor: '#0B2545',
                            backgroundColor: 'rgba(11, 37, 69, 0.05)',
                            borderWidth: 2,
                            borderDash: [4, 4],
                            fill: false,
                            tension: 0.35,
                            pointRadius: 2.5,
                            pointHoverRadius: 5,
                            pointBackgroundColor: '#0B2545',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 1.5
                        },
                        {
                            label: 'คอมพิวเตอร์',
                            data: desktopViews,
                            borderColor: '#8D38C9',
                            backgroundColor: 'rgba(141, 56, 201, 0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#8D38C9',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2
                        },
                        {
                            label: 'สมาร์ตโฟน',
                            data: mobileViews,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#3B82F6',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                boxWidth: 8,
                                boxHeight: 8,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { family: 'Sarabun', size: 10 },
                                color: '#4B5563',
                                padding: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: '#07192E',
                            titleFont: { family: 'Sarabun', size: 11 },
                            bodyFont: { family: 'Sarabun', size: 11 },
                            padding: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toLocaleString('th-TH') + ' ครั้ง';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { family: 'Sarabun', size: 10 },
                                color: '#9CA3AF'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#F3F4F6'
                            },
                            ticks: {
                                font: { family: 'Sarabun', size: 10 },
                                color: '#9CA3AF',
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>
