<x-public-layout>
    <x-slot name="title">ติดต่อเรา - คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    {{-- ── HERO SECTION ── --}}
    <div class="bg-navy py-16 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.08),transparent_50%)]"></div>
        <div class="max-w-[1200px] mx-auto px-6 relative z-10 text-center md:text-left">
            <div class="flex items-center justify-center md:justify-start gap-2 text-xs text-white/50 mb-3 uppercase tracking-wider font-semibold">
                <a href="{{ route('home') }}" class="hover:text-gold transition-colors">หน้าแรก</a>
                <span>·</span>
                <span class="text-white/80">ติดต่อเรา</span>
            </div>
            <h1 class="font-prompt text-3xl md:text-4xl font-bold tracking-tight mb-2">
                ติดต่อเรา
            </h1>
            <p class="text-white/70 font-light text-sm md:text-base max-w-xl">
                ช่องทางการติดต่อ สอบถามข้อมูล และแผนที่นำทาง คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา
            </p>
        </div>
    </div>

    {{-- ── MAIN CONTACT GRID ── --}}
    <div class="bg-off py-16">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Card 1: Address --}}
                <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col items-center text-center transition-all duration-300 hover:shadow-md">
                    <div class="w-16 h-16 rounded-full bg-teal/10 flex items-center justify-center text-3xl mb-6 shadow-inner">
                        📍
                    </div>
                    <h3 class="font-prompt text-lg font-bold text-navy mb-3">ที่อยู่สถาบัน</h3>
                    <div class="w-12 h-1 bg-gold/50 rounded-full mb-6"></div>
                    
                    <div class="text-sm text-navy/80 space-y-2 leading-relaxed">
                        <p class="font-semibold text-navy">คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</p>
                        <p class="font-light">19 หมู่ 2 ตำบลแม่กา อำเภอเมือง จังหวัดพะเยา 56000</p>
                        <div class="mt-4 p-3 bg-off rounded-xl border border-border-gray/50 text-left">
                            <span class="block text-[11px] text-muted font-semibold uppercase tracking-wider mb-1">พิกัดที่ตั้ง (GPS)</span>
                            <p class="text-xs">ละติจูด (Latitude): <strong class="font-mono">19.030318</strong></p>
                            <p class="text-xs">ลองจิจูด (Longitude): <strong class="font-mono">99.895958</strong></p>
                            <a href="https://www.google.com/maps?q=19.030318,99.895958" target="_blank" rel="noopener"
                               class="inline-block mt-1 text-xs font-semibold text-teal hover:underline">เปิดใน Google Maps ↗</a>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Contact Details --}}
                <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col items-center text-center transition-all duration-300 hover:shadow-md">
                    <div class="w-16 h-16 rounded-full bg-teal/10 flex items-center justify-center text-3xl mb-6 shadow-inner">
                        📞
                    </div>
                    <h3 class="font-prompt text-lg font-bold text-navy mb-3">ช่องทางการติดต่อ</h3>
                    <div class="w-12 h-1 bg-gold/50 rounded-full mb-6"></div>
                    
                    <div class="text-sm text-navy/80 space-y-4 w-full">
                        <div class="p-3 bg-off rounded-xl border border-border-gray/50 hover:bg-slate-50 transition-colors">
                            <span class="block text-[11px] text-muted font-semibold uppercase tracking-wider mb-1">เบอร์โทรศัพท์ติดต่อ</span>
                            <a href="tel:054466666" class="font-prompt text-base font-bold text-teal hover:text-teal-dark transition-colors">
                                054 466 666
                            </a>
                            <span class="block text-xs text-muted mt-0.5">ต่อ 3811 - 3812</span>
                        </div>

                        <div class="p-3 bg-off rounded-xl border border-border-gray/50 hover:bg-slate-50 transition-colors">
                            <span class="block text-[11px] text-muted font-semibold uppercase tracking-wider mb-1">อีเมลติดต่อกลาง</span>
                            <a href="mailto:medsci@up.ac.th" class="font-semibold text-teal hover:underline break-all">
                                medsci@up.ac.th
                            </a>
                        </div>

                        <div class="p-3 bg-off rounded-xl border border-border-gray/50 hover:bg-slate-50 transition-colors">
                            <span class="block text-[11px] text-muted font-semibold uppercase tracking-wider mb-1">ผู้ดูแลเว็บไซต์ (Webmaster)</span>
                            <a href="mailto:wittaya.su@up.ac.th" class="font-semibold text-teal hover:underline break-all">
                                wittaya.su@up.ac.th
                            </a>
                            <span class="block text-xs text-muted mt-0.5">โทร. 054 466 666 ต่อ 6222</span>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Q&A / Socials --}}
                <div class="card p-8 bg-white shadow-sm border border-border-gray flex flex-col items-center text-center transition-all duration-300 hover:shadow-md">
                    <div class="w-16 h-16 rounded-full bg-teal/10 flex items-center justify-center text-3xl mb-6 shadow-inner">
                        💬
                    </div>
                    <h3 class="font-prompt text-lg font-bold text-navy mb-3">ช่องสอบถามข้อมูล Q&A</h3>
                    <div class="w-12 h-1 bg-gold/50 rounded-full mb-6"></div>
                    
                    <div class="text-sm text-navy/80 space-y-5 w-full flex flex-col items-center">
                        <div class="w-full">
                            <span class="block text-[11px] text-muted font-semibold uppercase tracking-wider mb-2">Facebook Fanpage</span>
                            <a href="https://www.facebook.com/MedSciUP" target="_blank" rel="noopener" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-[#1877F2]/10 hover:bg-[#1877F2]/25 text-[#1877F2] font-semibold text-xs rounded-full transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                facebook.com/MedSciUP
                            </a>
                        </div>

                        <div class="w-full flex flex-col items-center">
                            <span class="block text-[11px] text-muted font-semibold uppercase tracking-wider mb-2">Line Official Account</span>
                            <div class="p-2 border border-border-gray rounded-2xl bg-white shadow-sm max-w-[150px]">
                                <img src="{{ asset('LineOAMedsci.jpg') }}" alt="Line OA QR Code" class="w-full h-auto rounded-lg" loading="lazy">
                            </div>
                            <span class="block text-[10px] text-muted mt-2">สแกน QR Code เพื่อแชทสอบถามข้อมูล</span>
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- ── GOOGLE MAPS BLOCK ── --}}
            <div class="mt-16 bg-white rounded-3xl border border-border-gray shadow-sm p-4 md:p-6 overflow-hidden">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-2xl">🗺️</span>
                    <div>
                        <h4 class="font-prompt text-base font-bold text-navy">แผนที่นำทางสถาบัน (Google Maps)</h4>
                        <p class="text-xs text-muted">ตำแหน่งที่ตั้ง คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา (19.030318, 99.895958)</p>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden border border-border-gray/50 h-[480px]">
                    <iframe title="แผนที่ Google Maps คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.7594581176586!2d99.8959582!3d19.030318299999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d9ccb3d334017d%3A0xcee7b0c966584f76!2sSchool%20of%20Medical%20Sciences!5e0!3m2!1sen!2sth!4v1783657101048!5m2!1sen!2sth" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            </div>

        </div>
    </div>
</x-public-layout>
