<x-public-layout>
    <x-slot name="title">สำหรับผู้สนใจศึกษาต่อ</x-slot>

    <!-- ── HERO SECTION ── -->
    <div class="relative text-white py-12 overflow-hidden" style="background-color: #1E0730;">
        <!-- Graphic backgrounds -->
        <div class="absolute right-0 top-0 w-1/2 h-full opacity-10 pointer-events-none hidden lg:block">
            <svg class="w-full h-full" style="color: #C4996C;" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                <polygon points="50,0 100,0 100,100 0,100" />
            </svg>
        </div>
        <div class="absolute -left-12 -top-12 w-64 h-64 rounded-full blur-3xl pointer-events-none" style="background-color: rgba(141, 56, 201, 0.15);"></div>
        <div class="absolute right-12 bottom-12 w-96 h-96 rounded-full blur-3xl pointer-events-none" style="background-color: rgba(196, 153, 108, 0.15);"></div>

        <div class="max-w-[1200px] mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-[1.2fr_0.8fr] gap-12 items-center">
            <div class="space-y-6">
                <span > <br/> </span>
                <h1 class="font-prompt text-2xl md:text-3xl font-bold leading-tight">
                    มาร่วมเป็นส่วนหนึ่งของ<br>
                    <span style="color: #C4996C;">คณะวิทยาศาสตร์การแพทย์</span> ม.พะเยา
                </h1>
                <p class="text-base md:text-lg text-white/80 font-light leading-relaxed max-w-[580px]">
                    เปิดประตูสู่อาชีพทางด้านการวิจัย การแพทย์ และอุตสาหกรรมสุขภาพ เรียนรู้ผ่านนวัตกรรมที่ทันสมัย ห้องปฏิบัติการระดับมาตรฐาน และอาจารย์ผู้เชี่ยวชาญระดับแนวหน้า
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="https://admission.up.ac.th/bachelor/homepage" target="_blank" 
                       class="inline-flex items-center gap-3 text-navy font-prompt font-bold text-sm py-4 px-8 rounded-2xl shadow-lg hover:-translate-y-0.5 transition-all duration-300" style="background: linear-gradient(to right, #C4996C, #DDBF9A); color: #1E0730; box-shadow: 0 10px 15px -3px rgba(196, 153, 108, 0.3);">
                        <span> &nbsp;📝 สมัครเข้าศึกษาต่อออนไลน์</span>
                        <span class="text-lg">➔ &nbsp;</span>
                    </a>
                    
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-2xl p-5 backdrop-blur-sm" style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div class="text-2xl mb-2">🔬</div>
                    <h3 class="font-prompt text-xs font-bold mb-1" style="color: #C4996C;">มาตรฐานห้องปฏิบัติการ</h3>
                    <p class="text-[11px] text-white/60 font-light leading-relaxed">ฝึกทักษะจริงด้วยอุปกรณ์วิจัยที่ล้ำสมัย</p>
                </div>
                <div class="rounded-2xl p-5 backdrop-blur-sm" style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div class="text-2xl mb-2">🏆</div>
                    <h3 class="font-prompt text-xs font-bold mb-1" style="color: #C4996C;">หลักสูตรคุณภาพ</h3>
                    <p class="text-[11px] text-white/60 font-light leading-relaxed">รับรองโดยสภาวิชาชีพและกระทรวงฯ</p>
                </div>
                <div class="rounded-2xl p-5 backdrop-blur-sm" style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div class="text-2xl mb-2">🤝</div>
                    <h3 class="font-prompt text-xs font-bold mb-1" style="color: #C4996C;">เครือข่ายสหกิจศึกษา</h3>
                    <p class="text-[11px] text-white/60 font-light leading-relaxed">ฝึกงานร่วมกับองค์กรชั้นนำทั้งในและต่างประเทศ</p>
                </div>
                <div class="rounded-2xl p-5 backdrop-blur-sm" style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                    <div class="text-2xl mb-2">💰</div>
                    <h3 class="font-prompt text-xs font-bold mb-1" style="color: #C4996C;">มีทุนการศึกษา</h3>
                    <p class="text-[11px] text-white/60 font-light leading-relaxed">สนับสนุนค่าเล่าเรียนและผลงานวิจัยดีเด่น</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ── WHY STUDY HERE SECTION ── -->
    <section class="bg-white py-16 border-b border-border-gray">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="text-center max-w-[600px] mx-auto mb-12">
                <h2 class="font-prompt text-xl md:text-2xl font-bold text-navy mb-3">
                    ทำไมต้องเรียนที่คณะวิทยาศาสตร์การแพทย์?
                </h2>
                <div class="w-16 h-1 bg-teal mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 space-y-3">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-2" style="background-color: rgba(13, 148, 136, 0.1); color: #0d9488;">🧬</div>
                    <h3 class="font-prompt text-lg font-bold text-navy">ความรู้ปรีคลินิกเข้มข้น</h3>
                    <p class="text-xs text-muted font-light leading-relaxed">
                        ปูพื้นฐานวิทยาศาสตร์การแพทย์ทุกด้านเพื่อต่อยอดในเชิงวิจัย วิเคราะห์ห้องปฏิบัติการ หรือศึกษาต่อระดับสูงได้อย่างมั่นใจ
                    </p>
                </div>
                <div class="text-center p-6 space-y-3">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-2" style="background-color: rgba(197, 160, 89, 0.2); color: #c5a059;">💼</div>
                    <h3 class="font-prompt text-lg font-bold text-navy">โอกาสทางอาชีพหลากหลาย</h3>
                    <p class="text-xs text-muted font-light leading-relaxed">
                        บัณฑิตเป็นที่ต้องการสูงในบริษัทชั้นนำ โรงพยาบาล ห้องปฏิบัติการวิเคราะห์ บริษัทอาหารและเครื่องสำอางทั่วประเทศ
                    </p>
                </div>
                <div class="text-center p-6 space-y-3">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-2" style="background-color: #f3e8ff; color: #7e22ce;">🍃</div>
                    <h3 class="font-prompt text-lg font-bold text-navy">สภาพแวดล้อมน่าอยู่</h3>
                    <p class="text-xs text-muted font-light leading-relaxed">
                        สัมผัสชีวิตนิสิตในมหาวิทยาลัยที่สวยงาม โอบล้อมด้วยธรรมชาติ พร้อมสิ่งอำนวยความสะดวกครบครัน สภาพแวดล้อมดีต่อการเรียนรู้
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── PROGRAMS SECTION ── -->
    <section id="programs-section" class="bg-gray-50 py-20 border-b border-border-gray">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="text-center max-w-[600px] mx-auto mb-16">
                <span class="text-teal font-prompt text-xs font-bold uppercase tracking-wider block mb-2">CHOOSE YOUR PATH</span>
                <h2 class="font-prompt text-xl md:text-2xl font-bold text-navy mb-3">
                    หลักสูตรระดับปริญญาตรีที่เปิดรับสมัคร
                </h2>
                <p class="text-xs text-muted font-light">เลือกหลักสูตรที่ตรงกับความฝันและความสนใจของคุณเพื่อสร้างอนาคตไปด้วยกัน</p>
                <div class="w-16 h-1 bg-teal mx-auto rounded mt-4"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($programs as $program)
                    <div class="bg-white rounded-2xl border border-border-gray overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <!-- Header Image/Color -->
                            <div class="h-44 relative p-6 flex flex-col justify-end text-white overflow-hidden"
                                 style="background: linear-gradient(to right, {{ $program->hero_color_from }}, {{ $program->hero_color_to }})">
                                @if($program->hero_image)
                                    <img src="{{ asset('storage/' . $program->hero_image) }}"
                                         alt="{{ $program->title_th }}"
                                         class="absolute inset-0 w-full h-full object-cover opacity-25 group-hover:scale-105 transition-transform duration-500">
                                @endif
                                <div class="relative z-10">
                                    <span class="text-[10px] text-white/70 tracking-wider uppercase font-bold block">{{ $program->degree_abbr_en }}</span>
                                    <h3 class="font-prompt text-lg font-bold leading-snug group-hover:text-gold transition-colors">{{ $program->title_th }}</h3>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 space-y-4">
                                <span class="badge badge-teal inline-block">{{ $program->degree_abbr_th }}</span>
                                @if($program->overview)
                                    <p class="text-xs text-muted font-light leading-relaxed line-clamp-3">
                                        {{ strip_tags($program->overview) }}
                                    </p>
                                @else
                                    <p class="text-xs text-muted font-light leading-relaxed">
                                        {{ $program->title_en }}
                                    </p>
                                @endif
                                
                                <div class="flex justify-between items-center text-xs text-navy font-semibold bg-off p-3 rounded-xl">
                                    <span>🕒 เรียน {{ $program->duration_years }} ปี</span>
                                    <span>📚 {{ $program->credits }} หน่วยกิต</span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Link -->
                        <div class="p-6 pt-0 border-t border-border-gray/50 flex justify-between items-center mt-4">
                            <span class="text-[11px] text-muted">ค่าเทอม ~{{ number_format($program->fee_per_semester) }} บาท/เทอม</span>
                            <a href="{{ route('programs.detail', $program->slug) }}" 
                               class="text-xs font-bold text-teal flex items-center gap-1 group-hover:gap-2 transition-all">
                                <span>รายละเอียดหลักสูตร</span>
                                <span>➔</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ── APPLICATION STEPS ── -->
    <section class="bg-white py-20 border-b border-border-gray">
        <div class="max-w-[1000px] mx-auto px-6">
            <div class="text-center max-w-[600px] mx-auto mb-16">
                <span class="text-teal font-prompt text-xs font-bold uppercase tracking-wider block mb-2">APPLICATION PROCESS</span>
                <h2 class="font-prompt text-2xl md:text-3xl font-bold text-navy mb-3">
                    ขั้นตอนการสมัครเรียนง่ายๆ
                </h2>
                <div class="w-16 h-1 bg-teal mx-auto rounded mt-4"></div>
            </div>

            <div class="relative grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative space-y-3 text-center">
                    <div class="w-12 h-12 rounded-full bg-teal text-white flex items-center justify-center font-prompt font-bold text-lg mx-auto z-10 relative">1</div>
                    <h4 class="font-prompt text-sm font-bold text-navy">เลือกหลักสูตร</h4>
                    <p class="text-[11px] text-muted font-light leading-relaxed">ศึกษาข้อมูลหลักสูตรและรายวิชาที่ชอบบนเว็บไซต์ของคณะ</p>
                </div>
                <!-- Step 2 -->
                <div class="relative space-y-3 text-center">
                    <div class="w-12 h-12 rounded-full bg-teal text-white flex items-center justify-center font-prompt font-bold text-lg mx-auto z-10 relative">2</div>
                    <h4 class="font-prompt text-sm font-bold text-navy">ตรวจสอบคุณสมบัติ</h4>
                    <p class="text-[11px] text-muted font-light leading-relaxed">ตรวจสอบวุฒิการศึกษา เกรดเฉลี่ยขั้นต่ำ และเกณฑ์การคัดเลือก</p>
                </div>
                <!-- Step 3 -->
                <div class="relative space-y-3 text-center">
                    <div class="w-12 h-12 rounded-full bg-teal text-white flex items-center justify-center font-prompt font-bold text-lg mx-auto z-10 relative">3</div>
                    <h4 class="font-prompt text-sm font-bold text-navy">สมัครออนไลน์</h4>
                    <p class="text-[11px] text-muted font-light leading-relaxed">กรอกข้อมูลและอัปโหลดเอกสารผ่านระบบ Admission UP</p>
                </div>
                <!-- Step 4 -->
                <div class="relative space-y-3 text-center">
                    <div class="w-12 h-12 rounded-full bg-gold text-navy flex items-center justify-center font-prompt font-bold text-lg mx-auto z-10 relative">4</div>
                    <h4 class="font-prompt text-sm font-bold text-navy">รอผลการคัดเลือก</h4>
                    <p class="text-[11px] text-muted font-light leading-relaxed">ประกาศผลผ่านเว็บไซต์และรายงานตัวขึ้นทะเบียนเป็นนิสิต</p>
                </div>
            </div>

            <!-- Big Bottom CTA -->
            <div class="mt-16 text-white rounded-3xl p-8 md:p-12 text-center relative overflow-hidden shadow-xl" style="background-color: #1E0730;">
                <div class="absolute -right-24 -bottom-24 w-64 h-64 rounded-full blur-2xl" style="background-color: rgba(141, 56, 201, 0.15);"></div>
                <div class="relative z-10 space-y-6">
                    <h3 class="font-prompt text-xl md:text-2xl font-bold" style="color: #C4996C;">พร้อมที่จะเริ่มอนาคตไปกับเราหรือยัง?</h3>
                    <p class="text-sm text-white/70 max-w-[600px] mx-auto font-light leading-relaxed">
                        สมัครเป็นนิสิตใหม่ในระบบรับตรงและโควตาประเภทต่างๆ <br/>ของมหาวิทยาลัยพะเยา ได้แล้ววันนี้ผ่านทางระบบออนไลน์
                    </p>
                    <div>
                        <a href="https://admission.up.ac.th/bachelor/homepage" target="_blank"
                           class="inline-flex items-center gap-3 text-navy font-prompt font-bold text-base py-4 px-10 rounded-2xl shadow-lg hover:scale-105 transition-all duration-300" style="background: linear-gradient(to right, #C4996C, #DDBF9A); color: #1E0730; box-shadow: 0 10px 15px -3px rgba(196, 153, 108, 0.3);">
                            สมัครเรียนออนไลน์ที่นี่ ➔
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── CONTACT ADMISSIONS ── -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-[800px] mx-auto px-6 text-center space-y-6">
            <h2 class="font-prompt text-xl md:text-2xl font-bold text-navy">มีคำถามเพิ่มเติมเกี่ยวกับการรับสมัคร?</h2>
            <p class="text-xs text-muted font-light max-w-[500px] mx-auto leading-relaxed">
                ติดต่อฝ่ายวิชาการและงานรับเข้าศึกษา คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา เพื่อรับคำแนะนำในการสมัครเรียนและสิทธิประโยชน์ต่างๆ
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 text-xs font-semibold text-navy">
                <div class="bg-white border border-border-gray px-6 py-4 rounded-2xl shadow-sm flex items-center justify-center gap-2">
                    <span>📞</span> <span>054-466-666 ต่อ 3811</span>
                </div>
                <div class="bg-white border border-border-gray px-6 py-4 rounded-2xl shadow-sm flex items-center justify-center gap-2">
                    <span>✉️</span> <span>medsci@up.ac.th</span>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
