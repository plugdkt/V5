<x-public-layout>
    <x-slot name="title">{{ $program->title_th }} | คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    <style>
        .program-content .plo-card {
            border-left: 3px solid {{ $program->hero_color_from }};
            transition: all 0.2s;
        }
        .program-content .plo-card:hover {
            background: {{ $program->hero_color_from }}0c;
            transform: translateX(3px);
        }
        .program-sidebar-sticky {
            position: sticky;
            top: 100px;
        }
    </style>

    <div class="program-content" x-data="{ activeYear: '1' }">

        {{-- ── HERO BANNER ── --}}
        <div class="text-white relative overflow-hidden py-16 md:py-20 bg-cover bg-center"
             style="background-image: linear-gradient(to right, {{ $program->hero_color_from }}f2, {{ $program->hero_color_to }}f2) @if($program->hero_image), url('{{ asset('storage/' . ltrim(str_replace('/storage/', '', $program->hero_image), '/')) }}')@endif;">
            {{-- decorative bg circles --}}
            <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-60 h-60 rounded-full bg-white/5 pointer-events-none"></div>

            <div class="max-w-[1200px] mx-auto px-6 relative z-10">
                {{-- Breadcrumb --}}
                <div class="flex items-center gap-2 text-xs text-white/60 font-semibold uppercase tracking-wider mb-4">
                    <a href="{{ route('home') }}" class="hover:text-gold transition-colors">หน้าแรก</a>
                    <span>/</span>
                    <a href="{{ route('programs') }}" class="hover:text-gold transition-colors">หลักสูตรที่เปิดสอน</a>
                    <span>/</span>
                    <span class="text-gold">{{ $program->slug }}</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-3 py-1 rounded-full text-xs font-bold text-white uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse inline-block"></span>
                            {{ strtoupper($program->slug) }} · วท.บ. {{ $program->duration_years }} ปี
                        </div>
                        <h1 class="font-prompt text-2.5xl md:text-3.5xl font-extrabold leading-tight text-white">
                            {{ $program->title_th }}
                        </h1>
                        <div class="w-16 h-1 bg-gold rounded-full"></div>
                        <p class="text-white/75 font-light text-sm leading-relaxed max-w-lg">
                            {{ Str::limit(strip_tags($program->overview), 180) }}
                        </p>
                        {{-- Quick Stats --}}
                        <div class="flex flex-wrap gap-4 pt-2">
                            <div class="bg-white/10 border border-white/15 rounded-xl px-4 py-2 text-center">
                                <div class="font-prompt text-lg font-bold text-white">{{ $program->credits }}</div>
                                <div class="text-[9px] text-white/60 uppercase tracking-wider mt-0.5">หน่วยกิต</div>
                            </div>
                            <div class="bg-white/10 border border-white/15 rounded-xl px-4 py-2 text-center">
                                <div class="font-prompt text-lg font-bold text-white">{{ $program->duration_years }} ปี</div>
                                <div class="text-[9px] text-white/60 uppercase tracking-wider mt-0.5">ระยะเวลาเรียน</div>
                            </div>
                            <div class="bg-white/10 border border-white/15 rounded-xl px-4 py-2 text-center">
                                <div class="font-prompt text-lg font-bold text-white">{{ $program->curriculum_year }}</div>
                                <div class="text-[9px] text-white/60 uppercase tracking-wider mt-0.5">ปรับปรุง พ.ศ.</div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Right Column: Image or Decorative box --}}
                    <div class="hidden lg:block">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-white/10">
                            @if($program->hero_image)
                                <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $program->hero_image), '/')) }}"
                                     alt="{{ $program->title_th }}"
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-white/5 backdrop-blur-sm flex flex-col items-center justify-center gap-3">
                                    <span class="text-5xl">🔬</span>
                                    <div class="text-center">
                                        <div class="text-white/80 font-prompt font-bold text-sm">{{ $program->title_en }}</div>
                                        <div class="text-white/40 text-xs mt-1">คณะวิทยาศาสตร์การแพทย์ มพ.</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── MAIN CONTENT ── --}}
        <div class="bg-off py-14">
            <div class="max-w-[1200px] mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-10 items-start">

                    {{-- Left: Main Content --}}
                    <div class="space-y-8">

                        {{-- Program Name Block --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-4 flex items-center gap-2">
                                <span class="w-1 h-6 rounded-full inline-block" style="background-color: {{ $program->hero_color_from }};"></span>
                                ชื่อหลักสูตรและปริญญา
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="rounded-xl p-4 border border-border-gray/50" style="background-color: {{ $program->hero_color_from }}0a;">
                                    <div class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color: {{ $program->hero_color_from }};">ภาษาไทย</div>
                                    <div class="text-sm font-semibold text-navy leading-snug">{{ $program->title_th }}</div>
                                    <div class="text-xs text-muted mt-2">ชื่อเต็ม: {{ $program->degree_full_th }}</div>
                                    <div class="text-xs text-muted">ชื่อย่อ: <strong class="text-navy">{{ $program->degree_abbr_th }}</strong></div>
                                </div>
                                <div class="bg-navy/5 rounded-xl p-4 border border-border-gray/50">
                                    <div class="text-[10px] text-navy font-bold uppercase tracking-widest mb-1">English</div>
                                    <div class="text-sm font-semibold text-navy leading-snug">{{ $program->title_en }}</div>
                                    <div class="text-xs text-muted mt-2">Full: {{ $program->degree_full_en }}</div>
                                    <div class="text-xs text-muted">Abbr: <strong class="text-navy">{{ $program->degree_abbr_en }}</strong></div>
                                </div>
                            </div>
                        </div>

                        {{-- Program Overview --}}
                        @if($program->overview)
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-4 flex items-center gap-2">
                                <span class="w-1 h-6 rounded-full inline-block" style="background-color: {{ $program->hero_color_from }};"></span>
                                ภาพรวมของหลักสูตร
                            </h2>
                            <div class="text-sm text-muted leading-loose font-light space-y-4">
                                {!! nl2br(e($program->overview)) !!}
                            </div>
                        </div>
                        @endif

                        {{-- PLOs Block --}}
                        @if($program->plos && count($program->plos) > 0)
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-2 flex items-center gap-2">
                                <span class="w-1 h-6 rounded-full inline-block" style="background-color: {{ $program->hero_color_from }};"></span>
                                ผลการเรียนรู้ที่คาดหวัง (PLOs)
                            </h2>
                            <p class="text-xs text-muted mb-5">หลักสูตรปรับปรุง พ.ศ. {{ $program->curriculum_year }}</p>
                            <div class="space-y-2.5">
                                @foreach($program->plos as $plo)
                                <div class="plo-card bg-white rounded-lg p-3.5 flex gap-3 items-start border border-border-gray/50">
                                    <span class="inline-block text-[10px] font-extrabold px-2 py-1 rounded-md mt-0.5 shrink-0 tracking-wider"
                                          style="background-color: {{ $program->hero_color_from }}15; color: {{ $program->hero_color_from }};">
                                        {{ $plo['code'] ?? '' }}
                                    </span>
                                    <p class="text-sm text-muted font-light leading-snug">{{ $plo['description'] ?? '' }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Curriculum by Year --}}
                        @if($program->curriculum && (
                            !empty($program->curriculum['year1']) ||
                            !empty($program->curriculum['year2']) ||
                            !empty($program->curriculum['year3']) ||
                            !empty($program->curriculum['year4'])
                        ))
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-5 flex items-center gap-2">
                                <span class="w-1 h-6 rounded-full inline-block" style="background-color: {{ $program->hero_color_from }};"></span>
                                การเรียนการสอนตามชั้นปี
                            </h2>
                            {{-- Year Tabs --}}
                            <div class="flex gap-2 mb-5 flex-wrap">
                                @foreach(['1', '2', '3', '4'] as $y)
                                    @if(!empty($program->curriculum['year' . $y]))
                                        <button @click="activeYear = '{{ $y }}'"
                                                :class="activeYear === '{{ $y }}' ? 'text-white' : 'bg-off text-muted border border-border-gray'"
                                                :style="activeYear === '{{ $y }}' ? 'background-color: {{ $program->hero_color_from }}; border-color: {{ $program->hero_color_from }};' : ''"
                                                class="text-xs font-bold px-4 py-2 rounded-lg cursor-pointer transition-all">
                                            ชั้นปีที่ {{ $y }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                            @foreach(['1', '2', '3', '4'] as $y)
                                @if(!empty($program->curriculum['year' . $y]))
                                    <div x-show="activeYear === '{{ $y }}'" class="text-sm text-muted font-light leading-loose">
                                        {!! nl2br(e($program->curriculum['year' . $y])) !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @endif

                        {{-- Career Paths --}}
                        @if($program->careers && count($program->careers) > 0)
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-5 flex items-center gap-2">
                                <span class="w-1 h-6 bg-gold rounded-full inline-block"></span>
                                อาชีพที่สามารถประกอบได้หลังสำเร็จการศึกษา
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($program->careers as $car)
                                <div class="flex gap-3 bg-off rounded-xl p-4 border border-border-gray/70">
                                    <span class="text-2xl mt-0.5 shrink-0">{{ $car['icon'] ?? '💼' }}</span>
                                    <div>
                                        <div class="text-sm font-bold text-navy">{{ $car['title'] ?? '' }}</div>
                                        <div class="text-xs text-muted font-light mt-0.5 leading-snug">{{ $car['description'] ?? '' }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>

                    {{-- Right Sidebar --}}
                    <aside class="program-sidebar-sticky space-y-5">

                        {{-- Curriculum Info Card --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm">
                            <h3 class="font-prompt text-base font-bold text-navy mb-4 border-b border-border-gray pb-3 flex items-center gap-2">
                                <span class="w-1 h-5 rounded-full inline-block" style="background-color: {{ $program->hero_color_from }};"></span>
                                ข้อมูลหลักสูตร
                            </h3>
                            <div class="space-y-3 text-xs">
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">จำนวนหน่วยกิตรวม</span>
                                    <strong class="text-navy">{{ $program->credits }} หน่วยกิต</strong>
                                </div>
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">ระยะเวลาการศึกษา</span>
                                    <strong class="text-navy">{{ $program->duration_years }} ปี</strong>
                                </div>
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">ค่าธรรมเนียมการศึกษา</span>
                                    <strong class="text-navy">{{ number_format($program->fee_per_semester) }} บาท/เทอม</strong>
                                </div>
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">ระดับปริญญา</span>
                                    <strong class="text-navy">ปริญญาตรี</strong>
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="text-muted">หลักสูตรปรับปรุง</span>
                                    <strong class="text-navy">พ.ศ. {{ $program->curriculum_year }}</strong>
                                </div>
                            </div>
                            <a href="https://reg.up.ac.th" target="_blank" rel="noopener"
                               style="background-color: {{ $program->hero_color_from }};"
                               class="mt-5 block text-center text-white text-xs font-bold py-3 rounded-xl transition-all hover:shadow-md hover:brightness-95">
                                สมัครเรียนหลักสูตรนี้
                            </a>
                        </div>

                        {{-- Related Programs --}}
                        @php
                            $otherPrograms = \App\Models\Program::where('is_active', true)->where('id', '!=', $program->id)->get();
                        @endphp
                        @if($otherPrograms->isNotEmpty())
                        <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm">
                            <h3 class="font-prompt text-base font-bold text-navy mb-4 border-b border-border-gray pb-3">หลักสูตรอื่น ๆ</h3>
                            <div class="space-y-2">
                                @foreach($otherPrograms as $op)
                                <a href="{{ route('programs.detail', $op->slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-off transition-colors text-sm font-medium text-navy border border-transparent hover:border-border-gray">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $op->hero_color_from }};"></span>
                                    {{ $op->title_th }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Contact Block --}}
                        <div class="text-white rounded-2xl p-6 shadow-sm" style="background-color: {{ $program->hero_color_from }};">
                            <h3 class="font-prompt text-sm font-bold mb-3">ต้องการข้อมูลเพิ่มเติม?</h3>
                            <p class="text-xs text-white/80 font-light leading-relaxed mb-4">ติดต่อสอบถามข้อมูลหลักสูตรได้ที่คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</p>
                            <a href="{{ route('contact') }}" class="block text-center bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-bold py-2.5 rounded-xl transition-all">
                                ติดต่อคณะฯ
                            </a>
                        </div>

                    </aside>
                </div>
            </div>
        </div>

    </div>
</x-public-layout>
