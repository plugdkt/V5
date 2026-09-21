<div class="grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-8">
    {{-- Left Sidebar: File Categories --}}
    <div class="space-y-4">
        <div class="bg-white rounded-2xl border border-border-gray p-5 shadow-sm">
            <h3 class="font-prompt text-sm font-bold text-navy mb-4 pb-2 border-b border-border-gray">
                หมวดหมู่เอกสาร
            </h3>
            <div class="flex flex-col gap-1">
                <button wire:click="selectCategory('')"
                        class="text-left px-3 py-2.5 rounded-lg text-xs font-semibold cursor-pointer transition-colors {{ empty($selectedCategoryId) ? 'bg-navy text-white' : 'hover:bg-off text-navy' }}">
                    📁 ทั้งหมด
                </button>
                @foreach($categories as $cat)
                    <button wire:click="selectCategory({{ $cat->id }})"
                            class="text-left px-3 py-2.5 rounded-lg text-xs font-semibold cursor-pointer transition-colors {{ $selectedCategoryId == $cat->id ? 'bg-navy text-white' : 'hover:bg-off text-navy' }}">
                        📁 {{ $cat->name }} ({{ $cat->files_count }})
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right Content: Files List --}}
    <div class="space-y-6">
        {{-- Search input --}}
        <div class="relative max-w-md">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input pr-10" placeholder="🔍 ค้นหาแบบฟอร์ม / เอกสารดาวน์โหลด...">
            @if($search)
                <button wire:click="$set('search', '')" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted hover:text-navy text-sm">✕</button>
            @endif
        </div>

        {{-- Files List Table --}}
        <div class="bg-white rounded-2xl border border-border-gray overflow-hidden shadow-sm">
            <div class="table-responsive">
                <table class="table w-full text-left text-xs font-light text-navy">
                    <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                        <tr>
                            <th class="p-4" width="70%">ชื่อเอกสาร</th>
                            <th class="p-4" width="15%">ขนาดไฟล์</th>
                            <th class="p-4 text-center" width="15%">ดาวน์โหลด</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray">
                        @forelse($files as $file)
                            <tr class="hover:bg-off/50 transition-colors">
                                <td class="p-4">
                                    <h4 class="font-bold text-sm text-navy mb-0.5 leading-snug">
                                        {{ $file->title }}
                                    </h4>
                                    @if($file->description)
                                        <p class="text-[11px] text-muted">{{ $file->description }}</p>
                                    @endif
                                    <span class="text-[10px] text-muted block mt-1">
                                        📁 หมวดหมู่: {{ $file->category->name }} &nbsp;|&nbsp; 📥 ดาวน์โหลดแล้ว: {{ $file->download_count }} ครั้ง
                                    </span>
                                </td>
                                <td class="p-4 text-muted whitespace-nowrap">
                                    {{ number_format($file->size / 1024, 1) }} KB
                                </td>
                                <td class="p-4 text-center">
                                    {{-- Using target="_blank" and download file route --}}
                                    <a href="{{ route('downloads.file', $file->id) }}" 
                                       wire:click="incrementDownload({{ $file->id }})"
                                       target="_blank"
                                       class="bg-gold text-navy font-bold px-4 py-2 rounded-lg text-xs hover:bg-gold-light inline-block transition-all shadow-sm">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-10 text-center text-muted">
                                    📭 ไม่พบเอกสารหรือแบบฟอร์มที่ต้องการดาวน์โหลด
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
