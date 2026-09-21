<div>
    @if(session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-6">
            {{ session('message') }}
        </div>
    @endif

    {{-- Tabs Switcher --}}
    <div class="flex border-b border-border-gray mb-6">
        <button wire:click="switchTab('files')" 
                class="py-2.5 px-6 font-prompt text-xs font-bold transition-all border-b-2 cursor-pointer {{ $activeTab === 'files' ? 'border-teal text-teal' : 'border-transparent text-muted hover:text-navy' }}">
            📄 จัดการไฟล์ดาวน์โหลด
        </button>
        <button wire:click="switchTab('categories')" 
                class="py-2.5 px-6 font-prompt text-xs font-bold transition-all border-b-2 cursor-pointer {{ $activeTab === 'categories' ? 'border-teal text-teal' : 'border-transparent text-muted hover:text-navy' }}">
            📁 จัดการหมวดหมู่เอกสาร
        </button>
    </div>

    {{-- ==================== TAB 1: FILES ==================== --}}
    @if($activeTab === 'files')
        @if(!$isFileFormOpen)
            {{-- Control Bar --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div class="flex gap-2 w-full sm:w-auto">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-input text-xs max-w-xs" placeholder="🔍 ค้นชื่อหรือไฟล์...">
                    <select wire:model.live="selectedCategory" class="form-select text-xs max-w-xs">
                        <option value="">-- หมวดหมู่ทั้งหมด --</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button wire:click="openFileForm()" class="btn-primary py-2 px-4 text-xs font-bold cursor-pointer shrink-0">
                    ＋ อัปโหลดไฟล์ใหม่
                </button>
            </div>

            {{-- Table List --}}
            <div class="overflow-hidden border border-border-gray rounded-xl">
                <table class="table w-full text-left text-xs font-light text-navy">
                    <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                        <tr>
                            <th class="p-4" width="35%">ชื่อเอกสาร</th>
                            <th class="p-4" width="20%">หมวดหมู่</th>
                            <th class="p-4" width="10%">ขนาดไฟล์</th>
                            <th class="p-4 text-center" width="12%">ยอดดาวน์โหลด</th>
                            <th class="p-4 w-20 text-center" width="10%">สถานะ</th>
                            <th class="p-4 text-center" width="13%">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray bg-white">
                        @forelse($filesList as $file)
                            <tr class="hover:bg-off/50">
                                <td class="p-4">
                                    <div class="font-bold text-navy mb-0.5">{{ $file->title }}</div>
                                    <div class="text-[10px] text-muted flex items-center gap-1.5 font-mono">
                                        <span>📁 {{ $file->original_name }}</span>
                                        @if($file->mime_type)
                                            <span class="text-white/60 bg-navy/40 px-1 py-0.5 rounded text-[8px] font-sans font-semibold uppercase">{{ explode('/', $file->mime_type)[1] ?? $file->mime_type }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 text-muted">
                                    {{ $file->category->name }}
                                </td>
                                <td class="p-4 text-muted font-mono">
                                    @if($file->size >= 1048576)
                                        {{ number_format($file->size / 1048576, 2) }} MB
                                    @else
                                        {{ number_format($file->size / 1024, 1) }} KB
                                    @endif
                                </td>
                                <td class="p-4 text-center font-bold text-navy font-mono">
                                    {{ number_format($file->download_count) }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="badge {{ $file->active ? 'badge-green' : 'badge-amber' }}">
                                        {{ $file->active ? 'เปิดใช้งาน' : 'ซ่อนไว้' }}
                                    </span>
                                </td>
                                <td class="p-4 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openFileForm({{ $file->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันที่จะลบไฟล์ดาวน์โหลดนี้ใช่หรือไม่?') || event.stopImmediatePropagation()" 
                                            wire:click="deleteFile({{ $file->id }})" 
                                            class="bg-red-50 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-100 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-muted">ไม่มีข้อมูลไฟล์เอกสารดาวน์โหลดในระบบ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $filesList->links() }}
            </div>
        @else
            {{-- File Editor Form --}}
            <div class="bg-off/30 rounded-2xl border border-border-gray p-6 space-y-6">
                <div class="flex justify-between items-center border-b border-border-gray pb-4">
                    <h3 class="font-prompt text-sm font-bold text-navy">
                        {{ $fileId ? '📝 แก้ไขรายละเอียดไฟล์เอกสาร' : '📂 อัปโหลดไฟล์เอกสารใหม่' }}
                    </h3>
                    <button wire:click="closeFileForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
                </div>

                <form wire:submit.prevent="saveFile" class="space-y-4 text-xs text-navy">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">ชื่อหัวข้อเอกสาร *</label>
                            <input type="text" wire:model="fileTitle" class="form-input font-bold" placeholder="เช่น แบบฟอร์มขออนุมัติเดินทางไปราชการ" required>
                        </div>

                        <div>
                            <label class="form-label">หมวดหมู่เอกสาร *</label>
                            <select wire:model="fileCategoryId" class="form-select font-bold" required>
                                <option value="">-- เลือกหมวดหมู่ --</option>
                                @foreach($allCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label">คำอธิบายเพิ่มเติม (ระบุหรือไม่ก็ได้)</label>
                        <textarea wire:model="fileDescription" rows="4" class="form-input w-full" placeholder="ระบุรายละเอียดเพิ่มเติม หรือคำแนะนำในการใช้แบบฟอร์มนี้..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">อัปโหลดไฟล์เอกสาร *</label>
                            <input type="file" wire:model="fileUpload" class="form-input pt-2" {{ !$fileId ? 'required' : '' }}>
                            
                            <div wire:loading wire:target="fileUpload" class="text-teal font-semibold mt-1">
                                ⏳ กำลังอัปโหลดไฟล์เข้าระบบ กรุณารอสักครู่...
                            </div>

                            @if($fileId && !$fileUpload)
                                <p class="text-[10px] text-muted mt-1">
                                    * มีไฟล์เดิมบันทึกอยู่แล้ว หากไม่ประสงค์เปลี่ยนไฟล์ สามารถเว้นว่างฟิลด์นี้ได้
                                </p>
                            @endif
                        </div>

                        <div>
                            <label class="form-label">สถานะการแสดงผล *</label>
                            <select wire:model="fileActive" class="form-select" required>
                                <option value="1">แสดงบนหน้าหลัก (เปิดใช้งาน)</option>
                                <option value="0">ซ่อนไว้ก่อน (ปิดใช้งาน)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 border-t border-border-gray pt-4">
                        <button type="button" wire:click="closeFileForm()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-200 cursor-pointer">
                            ✕ ยกเลิก
                        </button>
                        <button type="submit" class="bg-teal text-white px-6 py-2 rounded-lg font-bold hover:bg-teal-dark cursor-pointer shadow-md shadow-teal/10">
                            💾 บันทึกและอัปโหลดข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endif

    {{-- ==================== TAB 2: CATEGORIES ==================== --}}
    @if($activeTab === 'categories')
        @if(!$isCatFormOpen)
            {{-- Control Bar --}}
            <div class="flex justify-between items-center mb-6">
                <h4 class="font-prompt text-xs font-bold text-navy">📁 หมวดหมู่แบบฟอร์มเอกสารที่มีอยู่</h4>
                <button wire:click="openCatForm()" class="btn-primary py-2 px-4 text-xs font-bold cursor-pointer shrink-0">
                    ＋ สร้างหมวดหมู่ใหม่
                </button>
            </div>

            {{-- Table List --}}
            <div class="overflow-hidden border border-border-gray rounded-xl">
                <table class="table w-full text-left text-xs font-light text-navy">
                    <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                        <tr>
                            <th class="p-4 text-center" width="8%">ไอคอน</th>
                            <th class="p-4" width="42%">ชื่อหมวดหมู่</th>
                            <th class="p-4" width="25%">หมวดหมู่หลัก (Parent)</th>
                            <th class="p-4 text-center" width="10%">ลำดับ</th>
                            <th class="p-4 text-center" width="15%">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray bg-white font-medium">
                        @forelse($categoriesList as $cat)
                            <tr class="hover:bg-off/50">
                                <td class="p-4 text-center text-lg">
                                    {{ $cat->icon }}
                                </td>
                                <td class="p-4 text-navy">
                                    {{ $cat->name }}
                                </td>
                                <td class="p-4 text-muted">
                                    {{ $cat->parent ? $cat->parent->name : '-' }}
                                </td>
                                <td class="p-4 text-center font-mono">
                                    {{ $cat->order }}
                                </td>
                                <td class="p-4 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openCatForm({{ $cat->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันที่จะลบหมวดหมู่นี้ใช่หรือไม่? ไฟล์เอกสารภายในทั้งหมดจะถูกลบออกถาวรด้วย!') || event.stopImmediatePropagation()" 
                                            wire:click="deleteCategory({{ $cat->id }})" 
                                            class="bg-red-50 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-100 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-muted">ไม่มีข้อมูลหมวดหมู่เอกสารในระบบ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categoriesList->links() }}
            </div>
        @else
            {{-- Category Editor Form --}}
            <div class="bg-off/30 rounded-2xl border border-border-gray p-6 space-y-6">
                <div class="flex justify-between items-center border-b border-border-gray pb-4">
                    <h3 class="font-prompt text-sm font-bold text-navy">
                        {{ $catId ? '📝 แก้ไขหมวดหมู่เอกสาร' : '📁 สร้างหมวดหมู่เอกสารใหม่' }}
                    </h3>
                    <button wire:click="closeCatForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
                </div>

                <form wire:submit.prevent="saveCategory" class="space-y-4 text-xs text-navy">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">ชื่อหมวดหมู่ *</label>
                            <input type="text" wire:model="catName" class="form-input font-bold" placeholder="เช่น แบบฟอร์มสิทธิประโยชน์บุคลากร" required>
                        </div>

                        <div>
                            <label class="form-label">หมวดหมู่ระดับเหนือกว่า (Parent Category - มีหรือไม่มีก็ได้)</label>
                            <select wire:model="catParentId" class="form-select font-bold">
                                <option value="">-- เป็นหมวดหมู่หลักระดับแรกสุด --</option>
                                @foreach($allCategories as $c)
                                    @if($catId && $c->id == $catId) @continue @endif {{-- Prevent self-parenting --}}
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">ไอคอนแสดงผล (เช่น Emoji 📄 หรือ 📁)</label>
                            <input type="text" wire:model="catIcon" class="form-input" placeholder="เช่น 📁 หรือ 📄">
                        </div>

                        <div>
                            <label class="form-label">ลำดับการแสดงผล *</label>
                            <input type="number" wire:model="catOrder" class="form-input" required>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 border-t border-border-gray pt-4">
                        <button type="button" wire:click="closeCatForm()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-200 cursor-pointer">
                            ✕ ยกเลิก
                        </button>
                        <button type="submit" class="bg-teal text-white px-6 py-2 rounded-lg font-bold hover:bg-teal-dark cursor-pointer shadow-md shadow-teal/10">
                            💾 บันทึกข้อมูลหมวดหมู่
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endif
</div>
