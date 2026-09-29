<x-public-layout>
    <x-slot name="title">ค้นหา{{ $q !== '' ? ': ' . $q : '' }}</x-slot>

    <div class="bg-navy py-12 text-white">
        <div class="max-w-[1200px] mx-auto px-6">
            <h1 class="font-prompt text-3xl font-bold mb-4">ค้นหาข้อมูลในเว็บไซต์</h1>
            <form action="{{ route('search') }}" method="get" role="search" class="flex gap-2 max-w-2xl">
                <label for="search-page-q" class="sr-only">คำค้นหา</label>
                <input id="search-page-q" type="search" name="q" value="{{ $q }}" minlength="2" required
                       placeholder="พิมพ์คำค้นหา เช่น แผนยุทธศาสตร์ แบบฟอร์ม หลักสูตร"
                       class="flex-1 rounded-xl px-4 py-3 text-navy text-sm focus:outline-none focus:ring-2 focus:ring-gold">
                <button type="submit" class="bg-gold text-navy font-bold px-6 rounded-xl text-sm hover:bg-gold-light">ค้นหา</button>
            </form>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-10">
        @if($q === '')
            <p class="text-muted">กรุณาพิมพ์คำค้นหาอย่างน้อย 2 ตัวอักษร</p>
        @elseif(mb_strlen($q) < 2)
            <p class="text-muted">คำค้นหาสั้นเกินไป กรุณาพิมพ์อย่างน้อย 2 ตัวอักษร</p>
        @else
            <p class="text-sm text-muted mb-6" role="status">พบ {{ number_format($total) }} รายการ สำหรับ “<strong class="text-navy">{{ $q }}</strong>”</p>

            @forelse($groups as $group => $items)
                <section class="mb-8">
                    <h2 class="font-prompt text-lg font-bold text-navy border-b border-border-gray pb-2 mb-3">{{ $group }} <span class="text-xs text-muted font-normal">({{ $items->count() }})</span></h2>
                    <ul class="space-y-3">
                        @foreach($items as $item)
                            <li class="bg-white border border-border-gray rounded-xl p-4 hover:border-teal transition-colors">
                                <a href="{{ $item['url'] }}" class="font-semibold text-teal hover:underline">{{ $item['title'] }}</a>
                                @if(!empty($item['excerpt']))
                                    <p class="text-xs text-muted mt-1">{{ $item['excerpt'] }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </section>
            @empty
                <p class="text-muted">ไม่พบข้อมูลที่ตรงกับคำค้นหา ลองใช้คำอื่น หรือดู <a href="{{ route('sitemap.page') }}" class="text-teal underline">ผังเว็บไซต์</a></p>
            @endforelse
        @endif

        <div class="mt-8 p-4 bg-off border border-border-gray rounded-xl text-sm text-muted">
            ข่าวสารและกิจกรรมของคณะอยู่ในระบบข่าวสาร MSC News
            <a href="{{ $newsUrl }}" target="_blank" rel="noopener" class="text-teal underline font-semibold">ค้นหาข่าวในระบบ MSC News ↗</a>
        </div>
    </div>
</x-public-layout>
