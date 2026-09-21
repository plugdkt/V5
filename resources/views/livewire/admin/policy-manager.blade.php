<div>
    <!-- Tab Navigation -->
    <div class="flex border-b border-border-gray mb-6 gap-2">
        <button wire:click="$set('activeTab', 'items')" 
                class="py-2.5 px-4 font-prompt font-bold text-xs border-b-2 transition-all cursor-pointer"
                style="{{ $activeTab === 'items' ? 'border-color: #8D38C9; color: #8D38C9;' : 'border-color: transparent; color: #6B7280;' }}">
            📁 รายการแผน / เอกสารย่อย
        </button>
        <button wire:click="$set('activeTab', 'categories')" 
                class="py-2.5 px-4 font-prompt font-bold text-xs border-b-2 transition-all cursor-pointer"
                style="{{ $activeTab === 'categories' ? 'border-color: #8D38C9; color: #8D38C9;' : 'border-color: transparent; color: #6B7280;' }}">
            🗂️ หมวดหมู่แผนหลัก
        </button>
    </div>

    <!-- Alert Message -->
    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-xs mb-6 font-semibold">
            {{ session('message') }}
        </div>
    @endif

    <!-- ────────────────────────────────────────────── -->
    <!-- ── TAB 1: ITEMS (DOCUMENTS) ── -->
    <!-- ────────────────────────────────────────────── -->
    @if($activeTab === 'items')
        @if(!$isDocumentFormOpen)
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="flex flex-wrap gap-2 w-full md:w-auto flex-grow">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-input text-xs max-w-xs" placeholder="ค้นหาชื่อแผน/เอกสาร, กลุ่มย่อย...">
                    <select wire:model.live="filterCategoryId" class="form-select text-xs max-w-xs">
                        <option value="">-- หมวดหมู่ทั้งหมด --</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @if(count($filterGroups) > 0)
                        <select wire:model.live="filterGroupName" class="form-select text-xs max-w-xs">
                            <option value="">-- กลุ่มย่อยทั้งหมด --</option>
                            @foreach($filterGroups as $fGrp)
                                <option value="{{ $fGrp }}">{{ $fGrp }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <button wire:click="openDocumentForm()" class="font-bold px-4 py-2 text-xs rounded-lg hover:opacity-90 cursor-pointer shadow-md whitespace-nowrap flex items-center gap-1.5" style="background-color: #8D38C9; color: #FFFFFF;">
                    <span>➕</span>
                    <span>เพิ่มเอกสารใหม่</span>
                </button>
            </div>

            <div class="bg-white rounded-2xl border border-border-gray shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-border-gray text-navy font-bold bg-off/30">
                                <th class="p-3 w-20 text-center">ลำดับ</th>
                                <th class="p-3 w-48">หมวดหมู่หลัก</th>
                                <th class="p-3 w-60">กลุ่มย่อย / หัวข้อปี</th>
                                <th class="p-3">ชื่อแผนการดำเนินงาน / เอกสาร</th>
                                <th class="p-3 w-40">ไฟล์เอกสาร</th>
                                <th class="p-3 w-24 text-center">สถานะ</th>
                                <th class="p-3 w-32 text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-gray text-navy">
                            @forelse($documentsList as $doc)
                                <tr class="hover:bg-off/50 transition-colors">
                                    <td class="p-3 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-1">
                                            <span class="font-bold text-navy text-xs w-6">{{ $doc->sort_order }}</span>
                                            <div class="flex flex-col">
                                                <button type="button" wire:click="moveUp({{ $doc->id }})" title="เลื่อนขึ้นด้านบน" class="text-gray-400 hover:text-[#8D38C9] text-[10px] leading-tight cursor-pointer px-1">▲</button>
                                                <button type="button" wire:click="moveDown({{ $doc->id }})" title="เลื่อนลงด้านล่าง" class="text-gray-400 hover:text-[#8D38C9] text-[10px] leading-tight cursor-pointer px-1">▼</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-xs font-bold text-navy block">
                                            {{ $doc->category->name }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <div class="font-semibold text-[#8D38C9] flex items-center gap-1">
                                            <span>📁</span>
                                            <span>{{ $doc->group_name }}</span>
                                        </div>
                                        @if($doc->sub_group_name)
                                            <div class="text-[10px] text-orange-600 font-bold mt-1 bg-orange-50 px-2 py-0.5 rounded border border-orange-200 inline-block">
                                                🗓️ {{ $doc->sub_group_name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-3 font-medium">
                                        {{ $doc->title }}
                                    </td>
                                    <td class="p-3">
                                        <a href="{{ $doc->file_path }}" target="_blank" class="text-teal hover:underline font-semibold break-all text-[11px] flex items-center gap-1">
                                            <span>📄</span>
                                            <span class="truncate max-w-[140px]">{{ basename($doc->file_path) ?: 'ดูไฟล์' }}</span>
                                            <span>↗</span>
                                        </a>
                                    </td>
                                    <td class="p-3 text-center">
                                        <button type="button" 
                                                wire:click="toggleActive({{ $doc->id }})"
                                                title="คลิกเพื่อสลับ เปิด/ปิด ใช้งาน"
                                                class="px-2.5 py-1 rounded-full font-bold text-[10px] cursor-pointer transition-colors {{ $doc->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-400 hover:bg-gray-200' }}">
                                            {{ $doc->is_active ? '● เปิดใช้งาน' : '○ ปิดใช้งาน' }}
                                        </button>
                                    </td>
                                    <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                        <button wire:click="openDocumentForm({{ $doc->id }})" class="px-2.5 py-1.5 rounded-lg font-bold hover:opacity-90 cursor-pointer shadow-sm text-xs" style="background-color: #8D38C9; color: #FFFFFF;">
                                            แก้ไข
                                        </button>
                                        <button onclick="confirm('ยืนยันที่จะลบเอกสารแผนงานนี้ใช่หรือไม่?') || event.stopImmediatePropagation()" 
                                                wire:click="deleteDocument({{ $doc->id }})" 
                                                class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer text-xs">
                                            ลบ
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-10 text-center text-muted">ไม่พบข้อมูลแผนหรือนโยบายในระบบ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-border-gray bg-off/50">
                    {{ $documentsList->links() }}
                </div>
            </div>
        @else
            <!-- Document Form Editor -->
            <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-6 space-y-6">
                <!-- Form Header -->
                <div class="flex justify-between items-center border-b border-border-gray pb-4">
                    <div>
                        <h3 class="font-prompt text-base font-bold text-navy flex items-center gap-2">
                            <span>{{ $documentId ? '📝 แก้ไขข้อมูลแผนงาน / เอกสาร' : '✨ เพิ่มแผนงาน / เอกสารใหม่' }}</span>
                        </h3>
                        <p class="text-[11px] text-muted mt-0.5">กรอกข้อมูลตามขั้นตอนด้านล่าง ระบบจะจัดกลุ่มและจัดลำดับการแสดงผลให้อัตโนมัติ</p>
                    </div>
                    <button wire:click="closeDocumentForm()" class="text-xs bg-gray-100 hover:bg-gray-200 text-navy font-semibold px-3 py-1.5 rounded-lg cursor-pointer transition-colors">
                        ✕ ยกเลิก
                    </button>
                </div>

                <form wire:submit.prevent="saveDocument" class="space-y-6 text-xs text-navy">
                    
                    <!-- STEP 1: Categories and Group -->
                    <div class="bg-gray-50/70 border border-border-gray rounded-xl p-6 space-y-5">
                        <div class="font-prompt font-bold text-xs text-[#8D38C9] uppercase tracking-wider flex items-center gap-2 border-b border-border-gray/60 pb-3">
                            <span class="bg-[#8D38C9] text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[10px] font-bold">1</span>
                            <span>การจัดหมวดหมู่และกลุ่มย่อย</span>
                        </div>

                        <!-- 1.1 หมวดหมู่หลัก (Category) -->
                        <div class="bg-white border border-border-gray rounded-xl p-4 shadow-xs space-y-2">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <label class="form-label font-bold text-navy text-xs mb-0 flex items-center gap-1.5">
                                    <span>🗂️</span>
                                    <span>หมวดหมู่หลัก (Main Category)</span>
                                    <span class="text-red-500">*</span>
                                </label>
                                <span class="text-[11px] text-muted">
                                    เลือกหมวดหมู่หลักของนโยบายหรือแผนงาน
                                </span>
                            </div>
                            <div>
                                <select wire:model.live="documentCategoryId" class="form-select text-xs w-full bg-off/20 font-semibold text-navy">
                                    <option value="">-- เลือกหมวดหมู่แผนงานหลัก --</option>
                                    @foreach($allCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('documentCategoryId') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- 1.2 ชื่อกลุ่มย่อย (Accordion) -->
                        <div class="bg-white border border-border-gray rounded-xl p-4 shadow-xs space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-border-gray/40 pb-2.5">
                                <div>
                                    <label class="form-label font-bold text-navy text-xs mb-0 flex items-center gap-1.5">
                                        <span>📁</span>
                                        <span>ชื่อกลุ่มย่อย (หัวข้อแถบพับ Accordion บนหน้าเว็บ)</span>
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-[10px] text-muted mt-0.5">แถบพับเปิด-ปิดสำหรับจัดกลุ่มรวบรวมเอกสารชุดนี้ไว้ด้วยกันบนหน้าเว็บไซต์</p>
                                </div>

                                <!-- Segmented toggle buttons -->
                                <div class="inline-flex rounded-lg p-0.5 bg-gray-100 border border-gray-200 self-start sm:self-auto">
                                    <button type="button" 
                                            wire:click="cancelNewGroup()" 
                                            class="px-3 py-1 rounded-md text-[11px] font-bold transition-all cursor-pointer {{ !$isNewGroup ? 'bg-white text-[#8D38C9] shadow-xs' : 'text-gray-500 hover:text-navy' }}">
                                        📂 เลือกกลุ่มเดิมที่มีอยู่
                                    </button>
                                    <button type="button" 
                                            wire:click="switchToNewGroup()" 
                                            class="px-3 py-1 rounded-md text-[11px] font-bold transition-all cursor-pointer {{ $isNewGroup ? 'bg-[#8D38C9] text-white shadow-xs' : 'text-gray-500 hover:text-navy' }}">
                                        ➕ พิมพ์ตั้งชื่อกลุ่มใหม่
                                    </button>
                                </div>
                            </div>

                            @if(!$isNewGroup)
                                <div class="space-y-3 pt-1">
                                    <div>
                                        <label class="text-[11px] font-semibold text-navy block mb-1">คลิกเลือกจากกลุ่มย่อยเดิมในหมวดนี้:</label>
                                        <select wire:model.live="documentGroupName" class="form-select text-xs w-full bg-off/20 font-medium text-navy">
                                            <option value="">-- กรุณาคลิกเลือกกลุ่มย่อย --</option>
                                            @foreach($availableGroups as $grp)
                                                <option value="{{ $grp }}">{{ $grp }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @if(count($availableGroups) > 0)
                                        <div class="pt-1">
                                            <span class="text-[10px] text-muted font-semibold block mb-1.5">หรือคลิกเลือกด่วนจากรายการด้านล่างนี้:</span>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($availableGroups as $grp)
                                                    <button type="button" 
                                                            wire:click="selectExistingGroup('{{ addslashes($grp) }}')"
                                                            class="text-xs px-3 py-1.5 rounded-lg border cursor-pointer transition-all flex items-center gap-1.5 text-left {{ $documentGroupName === $grp ? 'bg-[#8D38C9] text-white border-[#8D38C9] font-bold shadow-xs' : 'bg-white text-navy border-border-gray hover:border-[#8D38C9] hover:bg-purple-50/50' }}">
                                                        <span>{{ $documentGroupName === $grp ? '✓' : '📁' }}</span>
                                                        <span>{{ $grp }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="space-y-2 pt-1">
                                    <label class="text-[11px] font-semibold text-navy block mb-0.5">ระบุชื่อกลุ่มย่อยใหม่ที่ต้องการสร้าง:</label>
                                    <input type="text" 
                                           wire:model.live.debounce.300ms="newGroupName" 
                                           class="form-input text-xs w-full bg-white text-navy" 
                                           placeholder="พิมพ์ชื่อกลุ่มย่อยใหม่ เช่น แผนบริหารจัดการความเสี่ยง หรือ รายงานผลการดำเนินงาน...">
                                    <div class="flex items-center gap-2 text-[11px] bg-purple-50 text-purple-900 border border-purple-100 px-3 py-2 rounded-lg">
                                        <span>💡</span>
                                        <span>ระบบจะสร้างแถบพับ Accordion ใหม่บนหน้าเว็บตามชื่อที่คุณพิมพ์นี้ให้อัตโนมัติ</span>
                                    </div>
                                </div>
                            @endif

                            @error('documentGroupName') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- STEP 2: Subgroup / Fiscal Year -->
                    <div class="bg-gray-50/70 border border-border-gray rounded-xl p-5 space-y-3">
                        <div class="font-prompt font-bold text-xs text-[#8D38C9] uppercase tracking-wider flex items-center gap-1.5">
                            <span class="bg-[#8D38C9] text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[10px]">2</span>
                            <span>หัวข้อรอง / กำกับปีงบประมาณ (ระบุหรือไม่ระบุก็ได้)</span>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 text-blue-900 rounded-lg p-3 text-[11px] leading-relaxed">
                            💡 <strong>คำแนะนำการใช้งาน:</strong>
                            <ul class="list-disc pl-4 mt-1 space-y-0.5">
                                <li><strong>หากต้องการแยกตามปี:</strong> ให้ระบุ เช่น <em>"ประจำปีงบประมาณ 2570"</em> หรือ <em>"2569"</em> เพื่อให้ระบบสร้างหัวข้อปีเล็กๆ เหนือรายการเอกสาร</li>
                                <li><strong>หากไม่ต้องการแบ่งย่อย:</strong> ให้คลิกปุ่ม <strong>[ ✕ ไม่ระบุ (เว้นว่างไว้) ]</strong> เอกสารจะแสดงเรียงกันต่อในแถบพับทันที</li>
                            </ul>
                        </div>

                        <div>
                            <div class="flex flex-wrap gap-1.5 mb-2 items-center">
                                <span class="text-[10px] text-muted font-bold">ปุ่มเลือกด่วน:</span>
                                <button type="button" wire:click="selectSubGroup('')" class="text-[10px] px-2.5 py-1 rounded-full border cursor-pointer transition-all {{ empty($documentSubGroupName) ? 'bg-navy text-white border-navy font-bold shadow-sm' : 'bg-white text-muted border-border-gray hover:bg-gray-100' }}">
                                    ✕ ไม่ระบุ (เว้นว่างไว้)
                                </button>
                                @php
                                    $presetYears = ['ประจำปีงบประมาณ 2570', 'ประจำปีงบประมาณ 2569', 'ประจำปีงบประมาณ 2568'];
                                    $allSubGroupPills = array_unique(array_merge($presetYears, $availableSubGroups));
                                @endphp
                                @foreach($allSubGroupPills as $preset)
                                    <button type="button" wire:click="selectSubGroup('{{ addslashes($preset) }}')" class="text-[10px] px-2.5 py-1 rounded-full border cursor-pointer transition-all {{ $documentSubGroupName === $preset ? 'bg-orange-500 text-white border-orange-500 font-bold shadow-sm' : 'bg-white text-navy border-border-gray hover:bg-gray-100' }}">
                                        {{ $preset }}
                                    </button>
                                @endforeach
                            </div>

                            <input type="text" wire:model="documentSubGroupName" class="form-input text-xs w-full bg-white" placeholder="หรือพิมพ์ระบุเอง เช่น ประจำปีงบประมาณ 2570 (เว้นว่างไว้ได้)">
                            @error('documentSubGroupName') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- STEP 3: Placement, Sort Order & Live Preview -->
                    <div class="bg-gray-50/70 border border-border-gray rounded-xl p-5 space-y-4">
                        <div class="font-prompt font-bold text-xs text-[#8D38C9] uppercase tracking-wider flex items-center gap-1.5">
                            <span class="bg-[#8D38C9] text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[10px]">3</span>
                            <span>ตำแหน่งและลำดับการแสดงผล (ไม่ต้องสลับหน้าเพื่อเช็ค)</span>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                            <!-- Left: Placement Options -->
                            <div class="space-y-3">
                                <label class="form-label font-bold text-navy text-xs mb-1 block">เลือกตำแหน่งที่ต้องการวางเอกสารนี้:</label>
                                
                                <div class="space-y-2">
                                    <label class="flex items-start gap-2.5 p-3 rounded-lg border cursor-pointer transition-all {{ $sortPlacement === 'top' ? 'border-[#8D38C9] bg-purple-50' : 'border-border-gray bg-white hover:bg-gray-50' }}">
                                        <input type="radio" wire:click="setSortPlacement('top')" name="sortPlacementChoice" value="top" {{ $sortPlacement === 'top' ? 'checked' : '' }} class="mt-0.5 text-[#8D38C9] focus:ring-[#8D38C9]">
                                        <div class="text-xs">
                                            <span class="font-bold text-navy block">🔼 แทรกเป็นลำดับแรกสุด (บนสุด)</span>
                                            <span class="text-[10px] text-muted">⭐ แนะนำสำหรับแผน/รายงานปีงบประมาณล่าสุด (ระบบจะตั้งเป็นลำดับที่ 1 และขยับรายการอื่นลงไปให้อัตโนมัติเมื่อบันทึก)</span>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-2.5 p-3 rounded-lg border cursor-pointer transition-all {{ $sortPlacement === 'bottom' ? 'border-[#8D38C9] bg-purple-50' : 'border-border-gray bg-white hover:bg-gray-50' }}">
                                        <input type="radio" wire:click="setSortPlacement('bottom')" name="sortPlacementChoice" value="bottom" {{ $sortPlacement === 'bottom' ? 'checked' : '' }} class="mt-0.5 text-[#8D38C9] focus:ring-[#8D38C9]">
                                        <div class="text-xs">
                                            <span class="font-bold text-navy block">🔽 ต่อท้ายสุด (ล่างสุด)</span>
                                            <span class="text-[10px] text-muted">วางต่อท้ายรายการสุดท้ายที่มีอยู่เดิมในกลุ่มนี้</span>
                                        </div>
                                    </label>

                                    <label class="flex items-start gap-2.5 p-3 rounded-lg border cursor-pointer transition-all {{ $sortPlacement === 'custom' ? 'border-[#8D38C9] bg-purple-50' : 'border-border-gray bg-white hover:bg-gray-50' }}">
                                        <input type="radio" wire:click="setSortPlacement('custom')" name="sortPlacementChoice" value="custom" {{ $sortPlacement === 'custom' ? 'checked' : '' }} class="mt-0.5 text-[#8D38C9] focus:ring-[#8D38C9]">
                                        <div class="text-xs flex-grow">
                                            <span class="font-bold text-navy block">✏️ กำหนดตัวเลขลำดับเอง</span>
                                            @if($sortPlacement === 'custom')
                                                <div class="mt-2 flex items-center gap-2">
                                                    <input type="number" wire:model.live="documentSortOrder" min="1" class="form-input text-xs w-24 font-bold text-center bg-white">
                                                    <span class="text-[11px] text-muted">(ลำดับที่ต้องการระบุ)</span>
                                                </div>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                                @error('documentSortOrder') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                            </div>

                            <!-- Right: Live Preview of current documents in this group -->
                            <div>
                                <div class="flex justify-between items-center mb-1.5">
                                    <label class="form-label font-bold text-navy text-xs mb-0">
                                        📋 เอกสารเดิมในกลุ่มนี้ (มี {{ count($groupDocuments) }} รายการ):
                                    </label>
                                    <span class="text-[10px] text-muted">ดูประกอบได้ทันที</span>
                                </div>

                                <div class="bg-white border border-border-gray rounded-lg p-3 max-h-56 overflow-y-auto space-y-1.5 shadow-inner">
                                    @forelse($groupDocuments as $gDoc)
                                        <div class="flex items-center gap-2 p-1.5 rounded text-[11px] {{ $documentId == $gDoc->id ? 'bg-purple-100 border border-purple-300 font-bold text-[#8D38C9]' : 'hover:bg-gray-50 text-navy' }}">
                                            <span class="bg-gray-100 border border-gray-300 text-navy font-bold text-[9px] px-1.5 py-0.5 rounded flex-shrink-0">
                                                ลำดับ {{ $gDoc->sort_order }}
                                            </span>
                                            <span class="truncate flex-grow" title="{{ $gDoc->title }}">
                                                {{ $gDoc->title }}
                                            </span>
                                            @if($documentId == $gDoc->id)
                                                <span class="text-[9px] text-[#8D38C9] font-bold flex-shrink-0">(รายการที่กำลังแก้ไข)</span>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="text-center py-6 text-muted text-[11px]">
                                            ยังไม่มีเอกสารในกลุ่มนี้<br>
                                            <span class="text-teal font-semibold">(เอกสารนี้จะแสดงเป็นลำดับที่ 1)</span>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: Document Name & File Attachment -->
                    <div class="bg-gray-50/70 border border-border-gray rounded-xl p-5 space-y-4">
                        <div class="font-prompt font-bold text-xs text-[#8D38C9] uppercase tracking-wider flex items-center gap-1.5">
                            <span class="bg-[#8D38C9] text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-[10px]">4</span>
                            <span>ชื่อเอกสาร และไฟล์แนบ</span>
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="form-label font-bold text-navy text-xs mb-1 block">
                                ชื่อรายการแผนการดำเนินงาน / เอกสาร <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="documentTitle" class="form-input text-xs w-full bg-white" placeholder="ตัวอย่าง: แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan) ประจำปีงบประมาณ 2570">
                            @error('documentTitle') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <!-- File Path -->
                        <div>
                            <label class="form-label font-bold text-navy text-xs mb-1 block">
                                ที่อยู่ลิงก์ไฟล์เอกสาร / PDF <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="text" id="document_file_path" wire:model="documentFilePath" class="form-input text-xs flex-grow bg-white" placeholder="เช่น https://www.medsci.up.ac.th/V5/storage/... หรือเลือกจากคลังสื่อ">
                                <button type="button" onclick="openFilePicker()" class="bg-teal text-white px-4 py-2 font-bold rounded-lg hover:bg-teal-dark cursor-pointer whitespace-nowrap text-xs shadow-sm flex items-center gap-1.5">
                                    <span>📂</span>
                                    <span>เลือกจากคลังสื่อ</span>
                                </button>
                            </div>
                            <p class="text-[10px] text-muted mt-1">สามารถกดปุ่ม "เลือกจากคลังสื่อ" เพื่อเลือกไฟล์ PDF ที่อัปโหลดไว้ หรือวาง URL ไฟล์ตรงได้ทันที</p>
                            @error('documentFilePath') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Active state -->
                        <div class="pt-2">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" wire:model="documentIsActive" id="documentIsActive" class="rounded border-border-gray text-[#8D38C9] focus:ring-[#8D38C9] w-4 h-4 cursor-pointer">
                                <span class="font-bold text-xs text-navy">เปิดใช้งานและแสดงผลบนหน้าเว็บทันที</span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-border-gray">
                        <button type="button" wire:click="closeDocumentForm()" class="bg-gray-100 hover:bg-gray-200 text-navy font-semibold px-5 py-2.5 rounded-lg cursor-pointer transition-colors text-xs">
                            ✕ ยกเลิก
                        </button>
                        <button type="submit" class="hover:opacity-90 font-bold px-6 py-2.5 rounded-lg cursor-pointer transition-all shadow-md text-xs flex items-center gap-1.5" style="background-color: #8D38C9; color: #FFFFFF;">
                            <span>💾</span>
                            <span>บันทึกข้อมูล</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endif

    <!-- ────────────────────────────────────────────── -->
    <!-- ── TAB 2: CATEGORIES ── -->
    <!-- ────────────────────────────────────────────── -->
    @if($activeTab === 'categories')
        @if(!$isCategoryFormOpen)
            <div class="flex justify-between items-center gap-4 mb-6">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-input text-xs max-w-xs" placeholder="ค้นหาชื่อหมวดหมู่หลัก...">
                <button wire:click="openCategoryForm()" class="font-bold px-4 py-2 text-xs rounded-lg hover:opacity-90 cursor-pointer shadow-md whitespace-nowrap" style="background-color: #8D38C9; color: #FFFFFF;">
                    ➕ เพิ่มหมวดหมู่ใหม่
                </button>
            </div>

            <div class="bg-white rounded-2xl border border-border-gray shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-border-gray text-navy font-bold">
                                <th class="p-3 w-16 text-center">ลำดับ</th>
                                <th class="p-3">ชื่อหมวดหมู่หลัก</th>
                                <th class="p-3 w-20 text-center">รายการเอกสาร</th>
                                <th class="p-3 w-20 text-center">สถานะ</th>
                                <th class="p-3 w-32 text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-gray text-navy">
                            @forelse($categoriesList as $cat)
                                <tr class="hover:bg-off/50">
                                    <td class="p-3 text-center font-bold">
                                        {{ $cat->sort_order }}
                                    </td>
                                    <td class="p-3 font-semibold text-navy">
                                        {{ $cat->name }}
                                    </td>
                                    <td class="p-3 text-center font-bold text-teal">
                                        {{ $cat->documents()->count() }}
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="px-2 py-0.5 rounded-full font-bold text-[9px] {{ $cat->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                            {{ $cat->is_active ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                        <button wire:click="openCategoryForm({{ $cat->id }})" class="px-2.5 py-1.5 rounded-lg font-bold hover:opacity-90 cursor-pointer" style="background-color: #8D38C9; color: #FFFFFF;">
                                            แก้ไข
                                        </button>
                                        <button onclick="confirm('ยืนยันที่จะลบหมวดหมู่แผนงานนี้ใช่หรือไม่? การลบหมวดหมู่จะทำให้รายการเอกสารภายใต้หมวดหมู่นี้ถูกลบทั้งหมด!') || event.stopImmediatePropagation()" 
                                                wire:click="deleteCategory({{ $cat->id }})" 
                                                class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                            ลบ
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-muted">ไม่พบข้อมูลหมวดหมู่แผนในระบบ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-border-gray bg-off/50">
                    {{ $categoriesList->links() }}
                </div>
            </div>
        @else
            <!-- Category Form Editor -->
            <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-6 space-y-6">
                <div class="flex justify-between items-center border-b border-border-gray pb-4">
                    <h3 class="font-prompt text-sm font-bold text-navy">
                        {{ $categoryId ? '📝 แก้ไขข้อมูลหมวดหมู่แผนงาน' : '✨ เพิ่มหมวดหมู่แผนงานใหม่' }}
                    </h3>
                    <button wire:click="closeCategoryForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
                </div>

                <form wire:submit.prevent="saveCategory" class="space-y-4 text-xs text-navy">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category Name -->
                        <div class="md:col-span-2">
                            <label class="form-label">ชื่อหมวดหมู่หลัก <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="categoryName" class="form-input text-xs" placeholder="ตัวอย่าง: แผนพัฒนาบุคลากร หรือ บริหารจัดการความเสี่ยง">
                            @error('categoryName') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label class="form-label">ลำดับการจัดเรียง <span class="text-red-500">*</span></label>
                            <input type="number" wire:model="categorySortOrder" class="form-input text-xs" placeholder="0">
                            @error('categorySortOrder') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <!-- Active state -->
                        <div>
                            <label class="form-label">เปิด/ปิด การแสดงผลหมวดหมู่นี้</label>
                            <div class="flex items-center gap-2 mt-2">
                                <input type="checkbox" wire:model="categoryIsActive" id="categoryIsActive" class="rounded border-border-gray text-[#8D38C9] focus:ring-[#8D38C9] w-4 h-4 cursor-pointer">
                                <label for="categoryIsActive" class="cursor-pointer font-semibold select-none">เปิดใช้งาน</label>
                            </div>
                            @error('categoryIsActive') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-6 border-t border-border-gray">
                        <button type="button" wire:click="closeCategoryForm()" class="bg-gray-100 hover:bg-gray-200 text-navy font-semibold px-4 py-2 rounded-lg cursor-pointer transition-colors">
                            ✕ ยกเลิก
                        </button>
                        <button type="submit" class="hover:opacity-90 font-bold px-5 py-2 rounded-lg cursor-pointer transition-colors shadow" style="background-color: #8D38C9; color: #FFFFFF;">
                            💾 บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endif

    <!-- Photo/File Picker Popup Script -->
    <script>
        function openFilePicker() {
            const width = 850;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            window.open('{{ route('admin.media.picker') }}', 'FilePicker', `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`);
        }

        window.selectPdfPath = function(url) {
            const input = document.getElementById('document_file_path');
            if (input) {
                input.value = url;
                input.dispatchEvent(new Event('input'));
            }
        };
    </script>
</div>
