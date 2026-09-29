<x-public-layout>
    <x-slot name="title">ผังเว็บไซต์</x-slot>
    <x-slot name="description">ผังเว็บไซต์ (Sitemap) แสดงโครงสร้างเนื้อหาทั้งหมดของเว็บไซต์คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</x-slot>

    <div class="bg-navy py-12 text-white">
        <div class="max-w-[1200px] mx-auto px-6">
            <h1 class="font-prompt text-3xl font-bold mb-1">ผังเว็บไซต์ (Sitemap)</h1>
            <p class="text-white/70 font-light text-sm">โครงสร้างเนื้อหาทั้งหมดของเว็บไซต์คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา</p>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <section class="bg-white border border-border-gray rounded-2xl p-6">
                <h2 class="font-prompt font-bold text-navy mb-3"><a href="{{ route('home') }}" class="hover:text-teal">หน้าหลัก</a></h2>
            </section>

            @foreach($menu as $item)
                @continue(rtrim((string) $item->url, '/') === rtrim(route('home'), '/') && $item->children->isEmpty())
                <section class="bg-white border border-border-gray rounded-2xl p-6">
                    <h2 class="font-prompt font-bold text-navy mb-3">
                        @if($item->url && $item->url !== '#')
                            <a href="{{ $item->url }}" target="{{ $item->target }}" class="hover:text-teal">{{ $item->title }}</a>
                        @else
                            {{ $item->title }}
                        @endif
                    </h2>
                    @if($item->children->isNotEmpty())
                        <ul class="space-y-1.5 text-sm">
                            @foreach($item->children as $child)
                                <li>
                                    @if($child->url && $child->url !== '#')
                                        <a href="{{ $child->url }}" target="{{ $child->target }}" class="text-navy/80 hover:text-teal">{{ $child->title }}</a>
                                    @else
                                        <span class="font-semibold text-navy">{{ $child->title }}</span>
                                    @endif
                                    @if($child->children->isNotEmpty())
                                        <ul class="pl-4 mt-1 space-y-1 border-l border-border-gray">
                                            @foreach($child->children as $sub)
                                                <li><a href="{{ $sub->url }}" target="{{ $sub->target }}" class="text-muted hover:text-teal">{{ $sub->title }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endforeach

            <section class="bg-white border border-border-gray rounded-2xl p-6">
                <h2 class="font-prompt font-bold text-navy mb-3">บริการและข้อมูลอื่น ๆ</h2>
                <ul class="space-y-1.5 text-sm">
                    <li><a href="{{ route('services') }}" class="text-navy/80 hover:text-teal">บริการออนไลน์ (E-Service)</a></li>
                    <li><a href="{{ route('downloads.index') }}" class="text-navy/80 hover:text-teal">แบบฟอร์มดาวน์โหลด</a></li>
                    <li><a href="{{ route('calendar.index') }}" class="text-navy/80 hover:text-teal">ปฏิทินกิจกรรม</a></li>
                    <li><a href="https://www.medsci.up.ac.th/msc_news/index.php" target="_blank" rel="noopener" class="text-navy/80 hover:text-teal">ข่าวสารและกิจกรรม (MSC News)</a></li>
                    <li><a href="{{ route('search') }}" class="text-navy/80 hover:text-teal">ค้นหาข้อมูลในเว็บไซต์</a></li>
                    <li><a href="{{ route('rss') }}" class="text-navy/80 hover:text-teal">RSS ข้อมูลเผยแพร่ล่าสุด</a></li>
                    @if(!empty($surveyUrl))
                        <li><a href="{{ $surveyUrl }}" target="_blank" rel="noopener" class="text-navy/80 hover:text-teal">แบบประเมินความพึงพอใจการใช้งานเว็บไซต์</a></li>
                    @endif
                </ul>
            </section>

            <section class="bg-white border border-border-gray rounded-2xl p-6">
                <h2 class="font-prompt font-bold text-navy mb-3">นโยบายและประกาศของเว็บไซต์</h2>
                <ul class="space-y-1.5 text-sm">
                    @foreach($policies as $slug => $name)
                        <li><a href="{{ route('pages.show', $slug) }}" class="text-navy/80 hover:text-teal">{{ $name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('pages.show', 'website-policy') }}#disclaimer" class="text-navy/80 hover:text-teal">ข้อจำกัดความรับผิด (Disclaimer)</a></li>
                </ul>
            </section>
        </div>
    </div>
</x-public-layout>
