<div>
    @if(session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-6">
            {{ session('message') }}
        </div>
    @endif

    {{-- File Upload Panel --}}
    <div class="bg-off p-5 border border-border-gray rounded-2xl mb-6">
        <h4 class="font-prompt text-xs font-bold text-navy mb-3 flex items-center gap-2">
            <span>📤</span> อัปโหลดไฟล์รูปภาพหรือเอกสารใหม่ (สูงสุด 10MB)
        </h4>
        <form wire:submit.prevent="uploadFiles" class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
            <div class="flex-grow">
                <input type="file" wire:model="fileUploads" multiple class="form-input text-xs py-1.5 px-3 bg-white">
                <div wire:loading wire:target="fileUploads" class="text-[10px] text-teal block mt-1">⏳ กำลังเตรียมไฟล์...</div>
                @error('fileUploads') <span class="text-red-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                @error('fileUploads.*') <span class="text-red-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn-primary py-2 px-6 text-xs font-bold w-full sm:w-auto cursor-pointer">
                เริ่มอัปโหลด
            </button>
        </form>

    </div>

    {{-- Filters & Controls --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" class="form-input max-w-xs text-xs" placeholder="🔍 ค้นหาชื่อไฟล์...">
        
        <select wire:model.live="filterType" class="form-select max-w-xs text-xs py-1.5 px-3 bg-white">
            <option value="all">ทั้งหมด (รูปและเอกสาร)</option>
            <option value="image">รูปภาพเท่านั้น</option>
            <option value="document">เอกสารและไฟล์อื่นๆ</option>
        </select>
    </div>

    {{-- Grid Gallery --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($files as $file)
            <div class="bg-white border border-border-gray rounded-2xl overflow-hidden flex flex-col justify-between shadow-sm hover:border-teal hover:shadow transition-all group relative">
                
                {{-- Preview Box --}}
                <div class="aspect-square bg-off flex items-center justify-center overflow-hidden border-b border-border-gray relative">
                    @if($file->is_image)
                        <img src="{{ $file->url }}" class="w-full h-full object-cover">
                    @else
                        {{-- File Icon based on mime-type --}}
                        <div class="flex flex-col items-center gap-2">
                            @if(str_contains($file->mime_type, 'pdf'))
                                <span class="text-4xl">📕</span>
                                <span class="bg-red-100 text-red-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">PDF</span>
                            @elseif(str_contains($file->mime_type, 'word') || str_contains($file->mime_type, 'document'))
                                <span class="text-4xl">📘</span>
                                <span class="bg-blue-100 text-blue-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">DOC</span>
                            @elseif(str_contains($file->mime_type, 'excel') || str_contains($file->mime_type, 'sheet'))
                                <span class="text-4xl">📗</span>
                                <span class="bg-green-100 text-green-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">XLS</span>
                            @else
                                <span class="text-4xl">📄</span>
                                <span class="bg-gray-100 text-gray-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">FILE</span>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Metadata Info --}}
                <div class="p-3 space-y-1 flex-grow flex flex-col justify-between">
                    <span class="text-[11px] font-bold text-navy truncate block" title="{{ $file->name }}">
                        {{ $file->name }}
                    </span>
                    <div class="flex justify-between items-center text-[10px] text-muted">
                        <span>{{ $file->formatted_size }}</span>
                        <span>{{ $file->created_at->format('d/m/y') }}</span>
                    </div>
                </div>

                {{-- Action Hover Overlay --}}
                <div class="absolute inset-0 bg-navy/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center p-3 gap-2">
                    @if($pickerMode)
                        <button onclick="selectFileForMce('{{ $file->url }}')" class="w-full bg-gold text-navy font-bold text-center py-2 rounded-lg text-xs hover:bg-gold-light cursor-pointer">
                            ✔ เลือกไฟล์นี้
                        </button>
                    @else
                        <button onclick="copyToClipboard('{{ $file->url }}')" class="w-full bg-white text-navy font-bold text-center py-2 rounded-lg text-xs hover:bg-off cursor-pointer">
                            🔗 คัดลอกลิงก์
                        </button>
                    @endif

                    <button onclick="confirm('ยืนยันที่จะลบไฟล์นี้อย่างถาวรหรือไม่?') || event.stopImmediatePropagation()" 
                            wire:click="deleteFile({{ $file->id }})" 
                            class="w-full bg-red-600 text-white font-bold text-center py-2 rounded-lg text-xs hover:bg-red-700 cursor-pointer">
                        🗑️ ลบไฟล์
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-muted text-xs">
                ไม่พบไฟล์รูปภาพหรือเอกสารในคลัง
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $files->links() }}
    </div>

    {{-- Script Helpers for selecting and copying URLs --}}
    <script>
        function selectFileForMce(url) {
            let targetUrl = url;
            const storageIndex = url.indexOf('/storage/');
            if (storageIndex !== -1) {
                targetUrl = url.substring(storageIndex);
            }
            if (window.opener && typeof window.opener.selectPdfPath === 'function') {
                window.opener.selectPdfPath(targetUrl);
                window.close();
            } else {
                // Opened in an iframe (TinyMCE)
                window.parent.postMessage({ mceAction: 'selectFile', url: targetUrl }, '*');
            }
        }




        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('คัดลอกที่อยู่ลิงก์รูปภาพ/ไฟล์ไปยังคลิปบอร์ดแล้ว!');
            }, function(err) {
                alert('ไม่สามารถคัดลอกได้: ', err);
            });
        }
    </script>
</div>
