<x-public-layout>
    <x-slot name="title">หน่วยงานภายใน คณะวิทยาศาสตร์การแพทย์ | มหาวิทยาลัยพะเยา</x-slot>

    {{-- ── HERO SECTION ── --}}
    <div class="relative py-16 md:py-20 text-white overflow-hidden bg-navy border-b border-white/10">
        <div class="absolute inset-0 bg-gradient-to-r from-[#07162B] to-[#0B2545] z-0"></div>
        <div class="max-w-[1200px] mx-auto px-6 relative z-10">
            <div class="text-center lg:text-left space-y-4">
                {{-- Breadcrumbs --}}
                <div class="flex items-center justify-center lg:justify-start gap-2.5 text-xs text-gold font-semibold uppercase tracking-wider">
                    <a href="{{ route('home') }}" class="hover:underline transition-all">หน้าแรก</a>
                    <span class="text-white/40">/</span>
                    <span class="text-white/80">เกี่ยวกับเรา</span>
                    <span class="text-white/40">/</span>
                    <span class="text-white/80">หน่วยงานภายใน</span>
                </div>
                
                {{-- Title --}}
                <h1 class="font-prompt text-3.5xl md:text-5xl font-bold tracking-tight text-white leading-tight">
                    หน่วยงานภายในคณะวิทยาศาสตร์การแพทย์
                </h1>
                
                {{-- Gold separator --}}
                <div class="w-16 h-1 bg-gold rounded-full mx-auto lg:mx-0"></div>
                
                {{-- Description --}}
                <p class="text-white/80 font-light text-sm md:text-base max-w-2xl leading-relaxed mx-auto lg:mx-0">
                    โครงสร้างหน่วยงานวิชาการและกลุ่มสาขาวิชา คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
                </p>
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT SECTION ── --}}
    <div class="bg-off py-16">
        <div class="max-w-[1200px] mx-auto px-6 space-y-12">
            
            {{-- Division Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                {{-- Division 1: Microbiology --}}
                <div class="card bg-white rounded-2xl border border-border-gray overflow-hidden shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                    <div>
                        <div class="h-48 relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('storage/media/banner_lab.png') }}');">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2545]/90 via-[#0B2545]/45 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="text-[10px] text-white/70 tracking-widest font-bold uppercase block mb-1">Division of Microbiology</span>
                                <h3 class="font-prompt text-lg font-bold text-white leading-tight">สาขาวิชาจุลชีววิทยา</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <span class="badge badge-teal">หลักสูตรระดับปริญญาตรี</span>
                                <span class="badge bg-[#0F7E5B]/10 text-[#0F7E5B] border border-[#0F7E5B]/20 font-bold text-[10px] px-2 py-0.5 rounded">วท.บ.</span>
                            </div>
                            <p class="text-xs text-muted leading-relaxed font-light line-clamp-4">
                                มุ่งเน้นการศึกษาเกี่ยวกับจุลินทรีย์ โครงสร้าง หน้าที่ และการสืบพันธุ์ของแบคทีเรีย เชื้อรา ยีสต์ สาหร่าย ปรสิต และไวรัส รวมถึงทักษะปฏิบัติการวิเคราะห์ปลอดเชื้อ การเพาะเลี้ยง การคัดแยกเชื้อบริสุทธิ์เพื่อประยุกต์ใช้ในอุตสาหกรรม การเกษตร อาหาร และการแพทย์
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('programs.detail', 'microbiology') }}" class="btn-primary w-full py-2.5 text-center text-xs font-bold transition-all shadow-sm">
                            ดูรายละเอียดหลักสูตร →
                        </a>
                    </div>
                </div>

                {{-- Division 2: Biochemistry --}}
                <div class="card bg-white rounded-2xl border border-border-gray overflow-hidden shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                    <div>
                        <div class="h-48 relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('storage/media/banner_dna.png') }}');">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2545]/90 via-[#0B2545]/45 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="text-[10px] text-white/70 tracking-widest font-bold uppercase block mb-1">Division of Biochemistry</span>
                                <h3 class="font-prompt text-lg font-bold text-white leading-tight">สาขาวิชาชีวเคมี</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <span class="badge badge-teal">หลักสูตรระดับปริญญาตรี</span>
                                <span class="badge bg-[#1B6CA8]/10 text-[#1B6CA8] border border-[#1B6CA8]/20 font-bold text-[10px] px-2 py-0.5 rounded">วท.บ.</span>
                            </div>
                            <p class="text-xs text-muted leading-relaxed font-light line-clamp-4">
                                มุ่งเน้นให้ผู้เรียนมีความรู้ความเข้าใจหลักการทางชีวเคมีระดับโมเลกุล ครอบคลุมทั้งโครงสร้างและหน้าที่ของสารชีวโมเลกุล ปฏิกิริยาเมแทบอลิซึม พันธุศาสตร์ระดับโมเลกุล เทคโนโลยีวิศวกรรมเอนไซม์ และการเพาะเลี้ยงเซลล์เพื่อประยุกต์ใช้ในอุตสาหกรรมเพื่อสุขภาพ
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('programs.detail', 'biochemistry') }}" class="btn-primary w-full py-2.5 text-center text-xs font-bold transition-all shadow-sm">
                            ดูรายละเอียดหลักสูตร →
                        </a>
                    </div>
                </div>

                {{-- Division 3: Nutrition and Dietetics --}}
                <div class="card bg-white rounded-2xl border border-border-gray overflow-hidden shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                    <div>
                        <div class="h-48 relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('storage/media/banner_campus.png') }}');">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2545]/90 via-[#0B2545]/45 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="text-[10px] text-white/70 tracking-widest font-bold uppercase block mb-1">Division of Nutrition</span>
                                <h3 class="font-prompt text-lg font-bold text-white leading-tight">สาขาวิชาโภชนาการและการกำหนดอาหาร</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <span class="badge badge-teal">หลักสูตรระดับปริญญาตรี</span>
                                <span class="badge bg-[#8B6914]/10 text-[#8B6914] border border-[#8B6914]/20 font-bold text-[10px] px-2 py-0.5 rounded">วท.บ.</span>
                            </div>
                            <p class="text-xs text-muted leading-relaxed font-light line-clamp-4">
                                มุ่งเน้นผลิตบัณฑิตให้มีความรู้และความเชี่ยวชาญในศาสตร์ของโภชนาการ โภชนบำบัด และการกำหนดอาหารทางการแพทย์ สำหรับการกำหนดอาหารผู้ป่วยเฉพาะโรค วินิจฉัยความต้องการสารอาหาร และให้คำปรึกษาด้านโภชนาการตามมาตรฐานวิชาชีพ
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('programs.detail', 'nutrition') }}" class="btn-primary w-full py-2.5 text-center text-xs font-bold transition-all shadow-sm">
                            ดูรายละเอียดหลักสูตร →
                        </a>
                    </div>
                </div>

                {{-- Division 4: Anatomy --}}
                <div class="card bg-white rounded-2xl border border-border-gray overflow-hidden shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                    <div>
                        <div class="h-48 relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('storage/media/banner_campus.png') }}');">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2545]/90 via-[#0B2545]/45 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="text-[10px] text-white/70 tracking-widest font-bold uppercase block mb-1">Division of Anatomy</span>
                                <h3 class="font-prompt text-lg font-bold text-white leading-tight">สาขาวิชากายวิภาคศาสตร์</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <span class="badge badge-navy">สาขาวิชาปรีคลินิก</span>
                                <span class="badge bg-amber-100 text-amber-700 border border-amber-200 font-bold text-[10px] px-2 py-0.5 rounded">วิชาวิทยาศาสตร์การแพทย์</span>
                            </div>
                            <p class="text-xs text-muted leading-relaxed font-light line-clamp-4">
                                ศึกษาเกี่ยวกับโครงสร้างร่างกายของสิ่งมีชีวิตและมนุษย์ ระบบกล้ามเนื้อ กระดูก ประสาท และอวัยวะภายใน เพื่อเป็นรากฐานความรู้ที่สำคัญยิ่งสำหรับนิสิตแพทย์ พยาบาล ทันตแพทย์ และวิทยาศาสตร์สุขภาพทุกสาขาวิชา
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('contact') }}" class="inline-block text-center text-xs font-bold text-teal hover:text-teal-dark border border-teal/20 hover:border-teal/50 bg-teal/5 w-full py-2.5 rounded-xl transition-all">
                            ติดต่อสาขาวิชา
                        </a>
                    </div>
                </div>

                {{-- Division 5: Physiology --}}
                <div class="card bg-white rounded-2xl border border-border-gray overflow-hidden shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                    <div>
                        <div class="h-48 relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('storage/media/banner_lab.png') }}');">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2545]/90 via-[#0B2545]/45 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="text-[10px] text-white/70 tracking-widest font-bold uppercase block mb-1">Division of Physiology</span>
                                <h3 class="font-prompt text-lg font-bold text-white leading-tight">สาขาวิชาสรีรวิทยา</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex gap-2 mb-3 flex-wrap">
                                <span class="badge badge-navy">สาขาวิชาปรีคลินิก</span>
                                <span class="badge bg-amber-100 text-amber-700 border border-amber-200 font-bold text-[10px] px-2 py-0.5 rounded">วิชาวิทยาศาสตร์การแพทย์</span>
                            </div>
                            <p class="text-xs text-muted leading-relaxed font-light line-clamp-4">
                                ศึกษาเกี่ยวกับหน้าที่และกลไกการทำงานประสานกันของระบบต่างๆ ในร่างกายมนุษย์ เช่น ระบบหายใจ ระบบกล้ามเนื้อและกระดูก ระบบต่อมไร้ท่อ และระบบไหลเวียนโลหิต เพื่อความเข้าใจในการรักษาสมดุลความปกติของสิ่งมีชีวิต
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('contact') }}" class="inline-block text-center text-xs font-bold text-teal hover:text-teal-dark border border-teal/20 hover:border-teal/50 bg-teal/5 w-full py-2.5 rounded-xl transition-all">
                            ติดต่อสาขาวิชา
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-public-layout>
