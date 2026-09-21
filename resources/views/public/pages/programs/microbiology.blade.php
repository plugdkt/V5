<x-public-layout>
    <x-slot name="title">หลักสูตรวิทยาศาสตรบัณฑิต สาขาวิชาจุลชีววิทยา | คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    <style>
        .micro-content { --accent: #0F7E5B; --accent-light: #E6F5F0; }
        .micro-content .plo-card {
            border-left: 3px solid #0F7E5B;
            transition: all 0.2s;
        }
        .micro-content .plo-card:hover {
            background: #E6F5F0;
            transform: translateX(3px);
        }
        .micro-content .year-tab.active { background: #0F7E5B; color: #fff; }
        .micro-content .year-tab { cursor: pointer; transition: all 0.2s; }
        .micro-content .year-content { display: none; }
        .micro-content .year-content.active { display: block; }
        .program-sidebar-sticky { position: sticky; top: 100px; }
    </style>

    <div class="micro-content">

        {{-- ── HERO BANNER ── --}}
        <div class="bg-gradient-to-br from-[#064731] via-[#0F7E5B] to-[#0B2545] text-white relative overflow-hidden py-16 md:py-20">
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
                    <span class="text-gold">จุลชีววิทยา</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-3 py-1 rounded-full text-xs font-bold text-green-200 uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse inline-block"></span>
                            MICROBIOLOGY · วท.บ. 4 ปี
                        </div>
                        <h1 class="font-prompt text-3xl md:text-4xl font-extrabold leading-tight text-white">
                            หลักสูตรวิทยาศาสตรบัณฑิต<br>
                            <span class="text-green-300">สาขาวิชาจุลชีววิทยา</span>
                        </h1>
                        <div class="w-16 h-1 bg-gold rounded-full"></div>
                        <p class="text-white/75 font-light text-sm leading-relaxed max-w-lg">
                            มุ่งสร้างบัณฑิตที่มีความรู้ความเข้าใจด้านจุลินทรีย์ ทั้งในเชิงวิทยาศาสตร์พื้นฐาน เทคโนโลยีชีวภาพ และการประยุกต์ใช้ทางการแพทย์และอุตสาหกรรม
                        </p>
                        {{-- Quick Stats --}}
                        <div class="flex flex-wrap gap-4 pt-2">
                            <div class="bg-white/10 border border-white/15 rounded-xl px-4 py-2.5 text-center">
                                <div class="font-prompt text-xl font-bold text-white">131</div>
                                <div class="text-[10px] text-white/60 uppercase tracking-wider mt-0.5">หน่วยกิต</div>
                            </div>
                            <div class="bg-white/10 border border-white/15 rounded-xl px-4 py-2.5 text-center">
                                <div class="font-prompt text-xl font-bold text-white">4 ปี</div>
                                <div class="text-[10px] text-white/60 uppercase tracking-wider mt-0.5">ระยะเวลาเรียน</div>
                            </div>
                            <div class="bg-white/10 border border-white/15 rounded-xl px-4 py-2.5 text-center">
                                <div class="font-prompt text-xl font-bold text-white">2565</div>
                                <div class="text-[10px] text-white/60 uppercase tracking-wider mt-0.5">ปีที่ปรับปรุง</div>
                            </div>
                        </div>
                    </div>
                    {{-- Right: Lab Hero Image --}}
                    <div class="hidden lg:block">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-white/10">
                            <img src="{{ asset('storage/media/microbiology_hero.png') }}"
                                 alt="ห้องปฏิบัติการจุลชีววิทยา คณะวิทยาศาสตร์การแพทย์"
                                 class="w-full h-64 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-2.5 text-center">
                                    <div class="text-white font-prompt font-bold text-sm">ห้องปฏิบัติการจุลชีววิทยา</div>
                                    <div class="text-white/70 text-xs mt-0.5">คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</div>
                                </div>
                            </div>
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
                                <span class="w-1 h-6 bg-[#0F7E5B] rounded-full inline-block"></span>
                                ชื่อหลักสูตรและปริญญา
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-[#E6F5F0] rounded-xl p-4">
                                    <div class="text-[10px] text-[#0F7E5B] font-bold uppercase tracking-widest mb-1">ภาษาไทย</div>
                                    <div class="text-sm font-semibold text-navy leading-snug">หลักสูตรวิทยาศาสตรบัณฑิต สาขาวิชาจุลชีววิทยา</div>
                                    <div class="text-xs text-muted mt-2">ชื่อเต็ม: วิทยาศาสตรบัณฑิต (จุลชีววิทยา)</div>
                                    <div class="text-xs text-muted">ชื่อย่อ: <strong class="text-navy">วท.บ. (จุลชีววิทยา)</strong></div>
                                </div>
                                <div class="bg-navy/5 rounded-xl p-4">
                                    <div class="text-[10px] text-navy font-bold uppercase tracking-widest mb-1">English</div>
                                    <div class="text-sm font-semibold text-navy leading-snug">Bachelor of Science Program in Microbiology</div>
                                    <div class="text-xs text-muted mt-2">Full: Bachelor of Science (Microbiology)</div>
                                    <div class="text-xs text-muted">Abbr: <strong class="text-navy">B.Sc. (Microbiology)</strong></div>
                                </div>
                            </div>
                        </div>

                        {{-- Program Overview --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-4 flex items-center gap-2">
                                <span class="w-1 h-6 bg-[#0F7E5B] rounded-full inline-block"></span>
                                ภาพรวมของหลักสูตร
                            </h2>
                            <p class="text-sm text-muted leading-loose font-light">
                                หลักสูตรจุลชีววิทยาเป็นหลักสูตรที่มุ่งเน้นให้ผู้เรียนมีความรู้ความเข้าใจในการศึกษาเกี่ยวกับจุลินทรีย์ และมีความชำนาญในทักษะปฏิบัติทางจุลชีววิทยา เนื้อหาครอบคลุมการศึกษาพื้นฐานเกี่ยวกับจุลินทรีย์และการประยุกต์ในด้านต่างๆ ทั้งวิทยาศาสตร์เทคโนโลยีและทางการแพทย์ ได้แก่ โครงสร้างและหน้าที่ของเซลล์จุลินทรีย์กลุ่มต่างๆ (แบคทีเรีย เชื้อรา ยีสต์ สาหร่าย ปรสิต รวมทั้งไวรัส) การเจริญและการสืบพันธุ์ เมแทบอลิซึม วิธีการควบคุมจุลินทรีย์ การจัดหมวดหมู่ และพันธุศาสตร์จุลินทรีย์
                            </p>
                            <p class="text-sm text-muted leading-loose font-light mt-3">
                                นอกจากนี้ผู้เรียนจะได้ฝึกปฏิบัติเทคนิคทางจุลชีววิทยา การเตรียมอุปกรณ์และตัวอย่าง การเตรียมอาหารเลี้ยงเชื้อ เทคนิคปลอดเชื้อ การคัดแยกเชื้อบริสุทธิ์ การเพาะเลี้ยง และการเก็บรักษาสายพันธุ์จุลินทรีย์ เพื่อพัฒนาและประยุกต์ใช้ในระดับอุตสาหกรรมและการแพทย์
                            </p>
                        </div>

                        {{-- PLOs Block --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-2 flex items-center gap-2">
                                <span class="w-1 h-6 bg-[#0F7E5B] rounded-full inline-block"></span>
                                ผลการเรียนรู้ที่คาดหวัง (PLOs)
                            </h2>
                            <p class="text-xs text-muted mb-5">หลักสูตรปรับปรุง พ.ศ. 2565</p>
                            <div class="space-y-2.5">
                                @foreach([
                                    ['PLO1','ผู้เรียนสามารถสื่อสารทั้งการพูด การเขียน และนำเสนอได้อย่างมีประสิทธิภาพ'],
                                    ['PLO2','ผู้เรียนสามารถเลือกใช้เทคโนโลยียุคดิจิทัล ในการสืบค้นข้อมูล และเรียนรู้ด้วยตัวเองได้อย่างเหมาะสม'],
                                    ['PLO3','ผู้เรียนสามารถปฏิบัติงานอย่างมีความรับผิดชอบ ยึดหลักคุณธรรมและจริยธรรมในการดำเนินชีวิตและทำงาน'],
                                    ['PLO4','ผู้เรียนสามารถทำงานร่วมกับผู้อื่น แสดงออกถึงคุณลักษณะความเป็นพลเมืองที่มีคุณค่าของสังคมไทยและสังคมโลก'],
                                    ['PLO5','ผู้เรียนสามารถแสดงออกซึ่งทักษะการเรียนรู้ตลอดชีวิต'],
                                    ['PLO6','ผู้เรียนสามารถออกแบบนวัตกรรมทางจุลชีววิทยาด้วยกระบวนการคิดเชิงออกแบบได้'],
                                    ['PLO7','ผู้เรียนสามารถอธิบายคุณลักษณะ ประโยชน์และโทษของจุลินทรีย์ได้'],
                                    ['PLO8','ผู้เรียนสามารถใช้เครื่องมือทางวิทยาศาสตร์ และปฏิบัติเทคนิคทางด้านจุลชีววิทยาได้'],
                                    ['PLO9','ผู้เรียนสามารถจัดจำแนกและวินิจฉัยจุลินทรีย์ได้'],
                                    ['PLO10','ผู้เรียนสามารถประยุกต์ความรู้ทางจุลชีววิทยาเพื่อวางแผน การจัดการ และนำไปใช้ประโยชน์ในงานทางวิทยาศาสตร์เทคโนโลยีและ/หรือทางการแพทย์'],
                                ] as [$code, $desc])
                                <div class="plo-card bg-white rounded-lg p-3.5 flex gap-3 items-start">
                                    <span class="inline-block bg-[#0F7E5B]/10 text-[#0F7E5B] text-[10px] font-extrabold px-2 py-1 rounded-md mt-0.5 shrink-0 tracking-wider">{{ $code }}</span>
                                    <p class="text-sm text-muted font-light leading-snug">{{ $desc }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Curriculum by Year --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-5 flex items-center gap-2">
                                <span class="w-1 h-6 bg-[#0F7E5B] rounded-full inline-block"></span>
                                การเรียนการสอนตามชั้นปี
                            </h2>
                            {{-- Year Tabs --}}
                            <div class="flex gap-2 mb-5 flex-wrap" id="yearTabs">
                                @foreach(['1','2','3','4'] as $y)
                                <button onclick="showYear('{{ $y }}')" id="tab-{{ $y }}" class="year-tab {{ $y == '1' ? 'active' : 'bg-off text-muted border border-border-gray' }} text-xs font-bold px-4 py-2 rounded-lg">
                                    ชั้นปีที่ {{ $y }}
                                </button>
                                @endforeach
                            </div>
                            <div id="year-1" class="year-content active text-sm text-muted font-light leading-loose">
                                เรียนในหมวดวิชาศึกษาทั่วไป ได้แก่ กลุ่มวิชาพื้นฐานทางภาษา (ไทยและอังกฤษ) กลุ่มวิชาเทคโนโลยีและการสื่อสารยุคดิจิทัล และกลุ่มวิชาทักษะชีวิต พร้อมกับหมวดวิชาเฉพาะในกลุ่มพื้นฐานวิทยาศาสตร์และคณิตศาสตร์ รวมถึงวิชาพื้นฐานของหลักสูตร ได้แก่ <strong>จุลชีววิทยาทั่วไป</strong> และ <strong>จุลชีววิทยาทางการแพทย์เบื้องต้น</strong>
                            </div>
                            <div id="year-2" class="year-content text-sm text-muted font-light leading-loose">
                                เรียนวิชาศึกษาทั่วไปและภาษาอังกฤษในระดับสูงขึ้น วิชาพื้นฐานเฉพาะด้านที่เน้นชีวเคมีและสถิติพื้นฐานทางการแพทย์ และกลุ่มวิชาเอกบังคับ ได้แก่ <strong>แบคทีเรียวิทยา ราวิทยา ปรสิตวิทยา</strong> วิชาทักษะวิชาการทางจุลชีววิทยา เทคนิคและการใช้เครื่องมือ พันธุศาสตร์จุลินทรีย์ และสรีรวิทยาและนิเวศวิทยาจุลินทรีย์
                            </div>
                            <div id="year-3" class="year-content text-sm text-muted font-light leading-loose">
                                เรียนวิชาเอกบังคับ ได้แก่ <strong>ไวรัสวิทยา ระเบียบวิธีวิจัย วิทยาภูมิคุ้มกัน จุลชีววิทยาอาหาร และจุลชีววิทยาอุตสาหกรรม</strong> นอกจากนี้ยังมีวิชาที่ส่งเสริมการเป็นผู้ประกอบการ เช่น กระบวนการคิดเชิงออกแบบ และบูรณาการความรู้สู่นวัตกรรม รวมถึงการพานิสิตออกทัศนศึกษาดูงานนอกสถานที่
                            </div>
                            <div id="year-4" class="year-content text-sm text-muted font-light leading-loose">
                                ภาคต้น เรียนวิชา<strong>ชีวสารสนเทศเบื้องต้น</strong> และ<strong>การจัดการและการประเมินคุณภาพห้องปฏิบัติการ</strong> พร้อมกับวิชาสัมมนาเพื่อนำความรู้ตลอด 3 ปีมาประยุกต์ใช้ ภาคปลาย นิสิตจะออกปฏิบัติ<strong>สหกิจศึกษา/ฝึกงาน</strong>ในเครือข่ายสถาบันและสถานประกอบการ หรือเลือกทำ<strong>การศึกษาอิสระ</strong>ที่ตนเองสนใจ
                            </div>
                        </div>

                        {{-- Career Paths --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 md:p-8 shadow-sm">
                            <h2 class="font-prompt text-lg font-bold text-navy mb-5 flex items-center gap-2">
                                <span class="w-1 h-6 bg-gold rounded-full inline-block"></span>
                                อาชีพที่สามารถประกอบได้หลังสำเร็จการศึกษา
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    ['🔬','นักจุลชีววิทยา / นักวิจัย','ในหน่วยงานราชการ โรงพยาบาล มหาวิทยาลัย สถาบันวิจัย และหน่วยงานเอกชน'],
                                    ['🧪','ผู้ช่วยนักวิจัย','ในหน่วยงานราชการ มหาวิทยาลัย สถาบันวิจัย องค์กรต่างๆ และโรงงาน'],
                                    ['🏭','ผู้ปฏิบัติงานด้านควบคุม / ประกันคุณภาพ','บริษัทด้านสุขภาพ ยา เวชภัณฑ์ อาหาร และเครื่องสำอาง'],
                                    ['🧬','ผู้แทนจำหน่าย / ผู้เชี่ยวชาญเครื่องมือ','วัสดุอุปกรณ์ทางวิทยาศาสตร์ สารเคมี ยา เวชภัณฑ์'],
                                    ['💡','ผู้ประกอบการ','ใช้ฐานความรู้ทางชีวเคมีและจุลชีววิทยา เช่น บริการทดสอบ ผลิตภัณฑ์สุขภาพและความงาม'],
                                ] as [$icon, $title, $desc])
                                <div class="flex gap-3 bg-off rounded-xl p-4 border border-border-gray">
                                    <span class="text-2xl mt-0.5 shrink-0">{{ $icon }}</span>
                                    <div>
                                        <div class="text-sm font-bold text-navy">{{ $title }}</div>
                                        <div class="text-xs text-muted font-light mt-0.5 leading-snug">{{ $desc }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    {{-- Right Sidebar --}}
                    <aside class="program-sidebar-sticky space-y-5">

                        {{-- Curriculum Info Card --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm">
                            <h3 class="font-prompt text-base font-bold text-navy mb-4 border-b border-border-gray pb-3 flex items-center gap-2">
                                <span class="w-1 h-5 bg-[#0F7E5B] rounded-full inline-block"></span>
                                ข้อมูลหลักสูตร
                            </h3>
                            <div class="space-y-3 text-xs">
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">จำนวนหน่วยกิตรวม</span>
                                    <strong class="text-navy">131 หน่วยกิต</strong>
                                </div>
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">ระยะเวลาการศึกษา</span>
                                    <strong class="text-navy">4 ปี (8 ภาคการศึกษา)</strong>
                                </div>
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">ค่าธรรมเนียมการศึกษา</span>
                                    <strong class="text-navy">16,000 บาท/เทอม</strong>
                                </div>
                                <div class="flex justify-between py-2 border-b border-border-gray/50">
                                    <span class="text-muted">ระดับปริญญา</span>
                                    <strong class="text-navy">ปริญญาตรี</strong>
                                </div>
                                <div class="flex justify-between py-2">
                                    <span class="text-muted">หลักสูตรปรับปรุง</span>
                                    <strong class="text-navy">พ.ศ. 2565</strong>
                                </div>
                            </div>
                            <a href="https://reg.up.ac.th" target="_blank" rel="noopener"
                               class="mt-5 block text-center bg-[#0F7E5B] hover:bg-[#0A6049] text-white text-xs font-bold py-3 rounded-xl transition-all hover:shadow-md">
                                สมัครเรียนหลักสูตรนี้
                            </a>
                        </div>

                        {{-- Related Programs --}}
                        <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm">
                            <h3 class="font-prompt text-base font-bold text-navy mb-4 border-b border-border-gray pb-3">หลักสูตรที่เกี่ยวข้อง</h3>
                            <div class="space-y-2">
                                <a href="{{ route('programs.detail', 'biochemistry') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-off transition-colors text-sm font-medium text-navy border border-transparent hover:border-border-gray">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                                    หลักสูตรชีวเคมี
                                </a>
                                <a href="{{ route('programs.detail', 'nutrition') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-off transition-colors text-sm font-medium text-navy border border-transparent hover:border-border-gray">
                                    <span class="w-2 h-2 rounded-full bg-orange-400 shrink-0"></span>
                                    หลักสูตรโภชนาการและการกำหนดอาหาร
                                </a>
                            </div>
                        </div>

                        {{-- Contact Block --}}
                        <div class="bg-[#0F7E5B] text-white rounded-2xl p-6 shadow-sm">
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

    <script>
        function showYear(y) {
            document.querySelectorAll('.year-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.year-tab').forEach(el => {
                el.classList.remove('active');
                el.classList.add('bg-off','text-muted','border','border-border-gray');
            });
            document.getElementById('year-' + y).classList.add('active');
            const tab = document.getElementById('tab-' + y);
            tab.classList.add('active');
            tab.classList.remove('bg-off','text-muted','border','border-border-gray');
        }
    </script>
</x-public-layout>
