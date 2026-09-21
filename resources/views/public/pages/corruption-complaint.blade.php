<x-public-layout>
    <x-slot name="title">ช่องทางแจ้งข้อร้องเรียนการทุจริต - คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    <style>
        .corruption-complaint-content p {
            line-height: 1.8 !important;
            letter-spacing: 0.01em !important;
        }
        .corruption-complaint-content .hero-desc {
            line-height: 1.7 !important;
        }
        .corruption-complaint-content .pdpa-btn {
            line-height: 1.5 !important;
        }
    </style>

    <div class="corruption-complaint-content">
        {{-- ── HERO SECTION ── --}}
        <div class="relative py-20 md:py-24 text-white overflow-hidden bg-navy border-b border-white/10">
            {{-- Dark brand color overlay gradient --}}
            <div class="absolute inset-0 bg-gradient-to-r from-[#07162B] to-[#0B2545] z-0"></div>
            
            <div class="max-w-[1200px] mx-auto px-6 relative z-10">
                <div class="text-center lg:text-left space-y-4">
                    {{-- Breadcrumbs --}}
                    <div class="flex items-center justify-center lg:justify-start gap-2.5 text-xs text-gold font-semibold uppercase tracking-wider">
                        <a href="{{ route('home') }}" class="hover:underline transition-all">หน้าแรก</a>
                        <span class="text-white/40">/</span>
                        <span class="text-white/80">ช่องทางแจ้งข้อร้องเรียนการทุจริต</span>
                    </div>
                    
                    {{-- Title --}}
                    <h1 class="font-prompt text-3.5xl md:text-5xl font-bold tracking-tight text-white leading-tight">
                        ช่องทางแจ้งข้อร้องเรียนการทุจริต
                    </h1>
                    
                    {{-- Gold separator --}}
                    <div class="w-16 h-1 bg-gold rounded-full mx-auto lg:mx-0"></div>
                    
                    {{-- Description --}}
                    <p class="text-white/80 font-light text-sm md:text-base max-w-2xl leading-relaxed mx-auto lg:mx-0 hero-desc">
                        ช่องทางสำหรับแจ้งเบาะแส ข้อร้องเรียนเกี่ยวกับการทุจริตและประพฤติมิชอบของบุคลากร คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
                    </p>
                </div>
            </div>
        </div>

    {{-- ── MAIN CONTENT SECTION ── --}}
    <div class="bg-off py-16">
        <div class="max-w-[1200px] mx-auto px-6 space-y-12">
            
            {{-- PDPA Consent Notice Banner --}}
            <div class="bg-white rounded-3xl p-6 border border-border-gray shadow-sm flex flex-col md:flex-row items-center gap-6">
                <div class="w-14 h-14 rounded-2xl bg-teal/10 flex-shrink-0 flex items-center justify-center text-2xl">
                    🔒
                </div>
                <div class="flex-grow space-y-1">
                    <h4 class="font-prompt text-sm font-bold text-navy">การคุ้มครองข้อมูลส่วนบุคคล (PDPA Notice)</h4>
                    <p class="text-xs text-muted leading-relaxed font-light">
                        มหาวิทยาลัยพะเยาจัดให้มีกระบวนการเก็บรวบรวม ใช้ และเปิดเผยข้อมูลส่วนบุคคล รวมถึงมาตรการรักษาความมั่นคงปลอดภัยของข้อมูลส่วนบุคคลที่เหมาะสม 
                        โดยคำนึงถึงสิทธิความเป็นส่วนตัวของบุคคล ความเป็นธรรมในการใช้ข้อมูลและความโปร่งใสต่อเจ้าของข้อมูลส่วนบุคคล
                    </p>
                </div>
                <a href="https://www.up.ac.th/IntroPDPA.aspx?tab=PDPA66" target="_blank" rel="noopener" 
                   class="inline-block text-xs font-bold text-teal hover:text-teal-dark border border-teal/20 hover:border-teal/50 px-4 py-2 rounded-xl transition-all whitespace-nowrap pdpa-btn">
                    ดูนโยบายคุ้มครองข้อมูลส่วนบุคคล
                </a>
            </div>

            {{-- 3 Main Complaint Channels --}}
            <div>
                <div class="text-center mb-8">
                    <span class="text-xs font-bold text-teal uppercase tracking-wider block mb-1">ช่องทางรับแจ้งหลัก</span>
                    <h2 class="font-prompt text-2xl font-bold text-navy">ส่งข้อร้องเรียนการทุจริต</h2>
                    <div class="w-12 h-1 bg-gold/50 rounded-full mx-auto mt-3"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    {{-- Channel 1: University --}}
                    <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col justify-between items-center text-center transition-all duration-300 hover:shadow-md">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-teal/10 flex items-center justify-center text-3xl mb-6 shadow-inner">
                                🏫
                            </div>
                            <h3 class="font-prompt text-base font-bold text-navy mb-2">มหาวิทยาลัยพะเยา</h3>
                            <p class="text-xs text-muted font-light leading-relaxed mb-6">
                                ช่องทางการรับเรื่องร้องเรียนกลางของมหาวิทยาลัยพะเยาโดยตรง ผ่านระบบการจัดการข้อร้องเรียนส่วนกลาง
                            </p>
                        </div>
                        <a href="https://www.up.ac.th/main-complaint.aspx" target="_blank" rel="noopener" 
                           class="btn-primary w-full py-2.5 text-xs font-bold shadow-sm">
                            ช่องทางร้องเรียน มพ.
                        </a>
                    </div>

                    {{-- Channel 2: NACC --}}
                    <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col justify-between items-center text-center transition-all duration-300 hover:shadow-md">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center text-3xl mb-6 shadow-inner">
                                🛡️
                            </div>
                            <h3 class="font-prompt text-base font-bold text-navy mb-2">สำนักงาน ป.ป.ช.</h3>
                            <p class="text-xs text-muted font-light leading-relaxed mb-6">
                                แจ้งเบาะแสการทุจริตหรือประพฤติมิชอบต่อสำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ (ป.ป.ช.)
                            </p>
                        </div>
                        <a href="https://wbs.nacc.go.th/" target="_blank" rel="noopener" 
                           class="btn-primary w-full py-2.5 text-xs font-bold shadow-sm">
                            ช่องทางร้องเรียน ป.ป.ช.
                        </a>
                    </div>

                    {{-- Channel 3: PACC --}}
                    <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col justify-between items-center text-center transition-all duration-300 hover:shadow-md">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-indigo-500/10 flex items-center justify-center text-3xl mb-6 shadow-inner">
                                ⚖️
                            </div>
                            <h3 class="font-prompt text-base font-bold text-navy mb-2">สำนักงาน ป.ป.ท.</h3>
                            <p class="text-xs text-muted font-light leading-relaxed mb-6">
                                ช่องทางแจ้งข้อร้องเรียนและตรวจสอบเรื่องร้องเรียนการทุจริตในภาครัฐ ผ่านระบบออนไลน์ของ สำนักงาน ป.ป.ท.
                            </p>
                        </div>
                        <a href="https://anonymous.pacc.go.th/" target="_blank" rel="noopener" 
                           class="btn-primary w-full py-2.5 text-xs font-bold shadow-sm">
                            ช่องทางร้องเรียน ป.ป.ท.
                        </a>
                    </div>

                </div>
            </div>

            {{-- Guidelines and Statistics Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Left Card: Practical Guidelines --}}
                <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📖</span>
                            <h3 class="font-prompt text-base font-bold text-navy">แนวปฏิบัติการจัดการเรื่องร้องเรียนการทุจริต</h3>
                        </div>
                        <p class="text-xs text-muted leading-relaxed font-light">
                            แนวปฏิบัติ ขั้นตอนกระบวนงาน และคู่มือการประเมินความเสี่ยงการทุจริตของมหาวิทยาลัยพะเยา เพื่อความโปร่งใสและตรวจสอบได้ของหน่วยงานภาครัฐ
                        </p>
                    </div>
                    <div class="mt-8 border-t border-border-gray/50 pt-6">
                        <a href="https://www.up.ac.th/pdf/complaint/%E0%B9%81%E0%B8%99%E0%B8%A7%E0%B8%9B%E0%B8%8F%E0%B8%B4%E0%B8%9B%E0%B8%B1%E0%B8%95%E0%B8%B4%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%88%E0%B8%B1%E0%B8%94%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A3%E0%B9%89%E0%B8%AD%E0%B8%87%E0%B9%80%E0%B8%A3%E0%B8%B5%E0%B8%A2%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%97%E0%B8%B8%E0%B8%88%E0%B8%A3%E0%B8%B4.pdf" 
                           target="_blank" rel="noopener" 
                           class="inline-flex items-center gap-2 text-xs font-bold text-teal hover:text-teal-dark border border-teal/10 hover:border-teal/30 bg-teal/5 px-4 py-2.5 rounded-xl transition-all">
                            📥 ดาวน์โหลดเอกสารแนวปฏิบัติ (PDF)
                        </a>
                    </div>
                </div>

                {{-- Right Card: Statistics --}}
                <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col justify-between transition-all duration-300 hover:shadow-md">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">📊</span>
                            <h3 class="font-prompt text-base font-bold text-navy">ข้อมูลสถิติเรื่องร้องเรียนการทุจริต</h3>
                        </div>
                        <p class="text-xs text-muted leading-relaxed font-light">
                            รายงานข้อมูลเชิงสถิติสรุปผลจำนวนคดี ข้อร้องเรียนเกี่ยวกับการทุจริตและการประพฤติมิชอบของหน่วยงาน ประจำปีงบประมาณ 2568
                        </p>
                    </div>
                    <div class="mt-8 border-t border-border-gray/50 pt-6 flex flex-wrap gap-3">
                        <a href="https://www.up.ac.th/pdf/2569/ita/o18/018%20%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B8%AA%E0%B8%96%E0%B8%B4%E0%B8%95%E0%B8%B4%E0%B9%80%E0%B8%A3%E0%B8%B7%E0%B9%88%E0%B8%AD%E0%B8%87%E0%B8%A3%E0%B9%89%E0%B8%AD%E0%B8%87%E0%B9%80%E0%B8%A3%E0%B8%B5%E0%B8%A2%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%97%E0%B8%B8%E0%B8%88%E0%B8%A3%E0%B8%B4%E0%B8%95%E0%B8%AF%202568.pdf" 
                           target="_blank" rel="noopener" 
                           class="inline-flex items-center gap-1.5 text-[11px] font-bold text-red-600 hover:text-red-700 border border-red-200 hover:border-red-300 bg-red-50/50 px-3 py-2 rounded-lg transition-all">
                            📕 สถิติ (PDF)
                        </a>
                        <a href="https://www.up.ac.th/pdf/2569/ita/o18/018%20%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B8%AA%E0%B8%96%E0%B8%B4%E0%B8%95%E0%B8%B4%E0%B9%80%E0%B8%A3%E0%B8%B7%E0%B9%88%E0%B8%AD%E0%B8%87%E0%B8%A3%E0%B9%89%E0%B8%AD%E0%B8%87%E0%B9%80%E0%B8%A3%E0%B8%B5%E0%B8%A2%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%97%E0%B8%B8%E0%B8%88%E0%B8%A3%E0%B8%B4%E0%B8%95%E0%B8%AF%202568.xlsx" 
                           target="_blank" rel="noopener" 
                           class="inline-flex items-center gap-1.5 text-[11px] font-bold text-green-700 hover:text-green-800 border border-green-200 hover:border-green-300 bg-green-50/50 px-3 py-2 rounded-lg transition-all">
                            📗 สถิติ (Excel)
                        </a>
                    </div>
                </div>

            </div>

            {{-- Status Check Banner --}}
            <div class="bg-gradient-to-r from-navy to-navy-dark rounded-3xl p-8 md:p-10 text-white relative overflow-hidden shadow-sm text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(16,185,129,0.08),transparent_50%)]"></div>
                <div class="relative z-10 space-y-2">
                    <h3 class="font-prompt text-xl font-bold">ต้องการติดตามผลหรือสถานะข้อร้องเรียน?</h3>
                    <p class="text-xs text-white/70 max-w-xl font-light leading-relaxed">
                        ท่านสามารถยื่นเรื่องและกลับมาตรวจสอบความคืบหน้าของรายงานและสถานะการตรวจสอบข้อร้องเรียนของท่านได้ตลอดเวลาผ่านศูนย์ระบบติดตามกลาง
                    </p>
                </div>
                <a href="https://www.up.ac.th/SResult.aspx" target="_blank" rel="noopener" 
                   class="relative z-10 inline-flex items-center gap-2 bg-gold hover:bg-gold-light text-navy font-bold text-xs px-6 py-3.5 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    🔍 ติดตามสถานะข้อร้องเรียน
                </a>
            </div>

        </div>
    </div>
</div>
</x-public-layout>
