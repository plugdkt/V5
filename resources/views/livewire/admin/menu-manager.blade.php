<div>
    <style>
        .row-level-1 {
            background-color: #f1f5f9 !important;
        }
        .row-level-1:hover {
            background-color: #e2e8f0 !important;
        }
        .row-level-2 {
            background-color: #f8fafc !important;
        }
        .row-level-2:hover {
            background-color: #f1f5f9 !important;
        }
        .row-level-3 {
            background-color: #ffffff !important;
        }
        .row-level-3:hover {
            background-color: #f8fafc !important;
        }
        .row-level-3 td:first-child {
            border-left: 4px solid #eab308 !important;
        }
    </style>

    @if(session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-6">
            {{ session('message') }}
        </div>
    @endif

    {{-- Control Filter bar --}}
    @if(!$isFormOpen)
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-navy">เลือกตำแหน่งเมนู:</span>
                <select wire:model.live="locationFilter" class="form-select max-w-xs text-xs py-1.5 px-3">
                    <option value="header">เมนูหลักแถบด้านบน (Header Navigation)</option>
                    <option value="footer_about">ลิงก์เมนูส่วนล่าง - เกี่ยวกับคณะ (Footer About)</option>
                    <option value="footer_programs">ลิงก์เมนูส่วนล่าง - หลักสูตร (Footer Programs)</option>
                    <option value="footer_services">ลิงก์เมนูส่วนล่าง - บริการภายใน (Footer Services)</option>
                </select>
            </div>
            
            <button wire:click="openForm()" class="btn-primary py-2 px-4 text-xs font-bold cursor-pointer">
                ＋ เพิ่มเมนูใหม่
            </button>
        </div>

        {{-- Menus List Table --}}
        <div class="overflow-hidden border border-border-gray rounded-xl">
            <table class="table w-full text-left text-xs font-light text-navy">
                <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                    <tr>
                        <th class="p-4" width="8%">ลำดับ</th>
                        <th class="p-4" width="37%">ชื่อเมนู (ภาษาไทย / English)</th>
                        <th class="p-4" width="30%">ที่อยู่เว็บ (URL / Link)</th>
                        <th class="p-4" width="10%">การเปิดแสดง</th>
                        <th class="p-4 text-center" width="15%">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-gray bg-white">
                    @forelse($menus as $menu)
                        {{-- Top Level Menu Item --}}
                        <tr class="row-level-1 font-semibold text-xs border-b border-border-gray">
                            <td class="p-4 font-bold text-teal text-center">
                                {{ $menu->order }}
                            </td>
                            <td class="p-4">
                                <span class="text-xs font-bold text-navy">{{ $menu->title_th }}</span>
                                @if($menu->title_en)
                                    <span class="text-[10px] text-muted block font-normal uppercase mt-0.5">{{ $menu->title_en }}</span>
                                @endif
                            </td>
                            <td class="p-4 font-mono text-xs text-muted">
                                {{ $menu->url }} 
                                <span class="text-[10px] text-gold font-normal">({{ $menu->target }})</span>
                            </td>
                            <td class="p-4">
                                <span class="badge {{ $menu->active ? 'badge-green' : 'badge-amber' }}">
                                    {{ $menu->active ? 'แสดงผล' : 'ซ่อนไว้' }}
                                </span>
                            </td>
                            <td class="p-4 text-center space-x-1 whitespace-nowrap">
                                <button wire:click="openForm({{ $menu->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                    แก้ไข
                                </button>
                                <button onclick="confirm('ยืนยันลบเมนูนี้หรือไม่? (รวมทั้งเมนูย่อยทั้งหมด)') || event.stopImmediatePropagation()" 
                                        wire:click="deleteMenu({{ $menu->id }})" 
                                        class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                    ลบ
                                </button>
                            </td>
                        </tr>

                        {{-- Children Sub-Menu Items (if any) --}}
                        @foreach($menu->children as $child)
                            <tr class="row-level-2 text-xs border-b border-border-gray">
                                <td class="p-4 text-right pr-6 text-muted font-mono">
                                    ↳ {{ $child->order }}
                                </td>
                                <td class="p-4 pl-8">
                                    <span class="text-xs font-semibold text-navy">{{ $child->title_th }}</span>
                                    @if($child->title_en)
                                        <span class="text-[10px] text-muted block font-normal uppercase mt-0.5">{{ $child->title_en }}</span>
                                    @endif
                                </td>
                                <td class="p-4 font-mono text-xs text-muted pl-6">
                                    {{ $child->url }} 
                                    <span class="text-[10px] text-gold font-normal">({{ $child->target }})</span>
                                </td>
                                <td class="p-4">
                                    <span class="badge {{ $child->active ? 'badge-green' : 'badge-amber' }}">
                                        {{ $child->active ? 'แสดงผล' : 'ซ่อนไว้' }}
                                    </span>
                                </td>
                                <td class="p-4 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openForm({{ $child->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันลบเมนูย่อยนี้หรือไม่?') || event.stopImmediatePropagation()" 
                                            wire:click="deleteMenu({{ $child->id }})" 
                                            class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                            {{-- Level 3: Mega Menu Sub-Links --}}
                            @foreach($child->children as $sublink)
                                <tr class="row-level-3 text-xs border-b border-border-gray">
                                    <td class="p-3 text-right pr-12 text-muted font-mono">
                                        ↳ ↳ {{ $sublink->order }}
                                    </td>
                                    <td class="p-3 pl-12">
                                        <span class="text-xs font-medium text-navy/85">{{ $sublink->title_th }}</span>
                                        @if($sublink->title_en)
                                            <span class="text-[10px] text-muted block font-normal uppercase mt-0.5">{{ $sublink->title_en }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 font-mono text-xs text-muted pl-12">
                                        {{ $sublink->url }} 
                                        <span class="text-[10px] text-gold font-normal">({{ $sublink->target }})</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-0.5 rounded-full font-bold text-[10px] {{ $sublink->active ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $sublink->active ? 'แสดงผล' : 'ซ่อนไว้' }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                        <button wire:click="openForm({{ $sublink->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                            แก้ไข
                                        </button>
                                        <button onclick="confirm('ยืนยันลบเมนูระดับสามนี้หรือไม่?') || event.stopImmediatePropagation()" 
                                                wire:click="deleteMenu({{ $sublink->id }})" 
                                                class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                            ลบ
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-muted">ไม่พบข้อมูลเมนูนำทางในตำแหน่งนี้</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        {{-- Form editor --}}
        <div class="space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $menuId ? '📝 แก้ไขข้อมูลเมนูนำทาง' : '✨ เพิ่มเมนูนำทางใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="saveMenu" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-off p-6 border border-border-gray rounded-2xl">
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">ชื่อปุ่มเมนู (ภาษาไทย)</label>
                            <input type="text" wire:model="title_th" class="form-input" placeholder="เช่น ประวัติองค์กร..." required>
                        </div>

                        <div>
                            <label class="form-label">ชื่อปุ่มเมนู (ภาษาอังกฤษ - ถ้ามี)</label>
                            <input type="text" wire:model="title_en" class="form-input" placeholder="e.g. History...">
                        </div>

                        <div>
                            <label class="form-label font-bold text-navy mb-1.5 block">ประเภทลิงก์ที่ต้องการเชื่อมโยง</label>
                            <div class="flex gap-4 mb-2">
                                <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                    <input type="radio" wire:model.live="linkType" value="page" class="w-4 h-4 text-teal border-border-gray rounded-full focus:ring-teal cursor-pointer">
                                    <span>เลือกหน้าเพจในระบบ</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer text-xs">
                                    <input type="radio" wire:model.live="linkType" value="custom" class="w-4 h-4 text-teal border-border-gray rounded-full focus:ring-teal cursor-pointer">
                                    <span>กำหนดลิงก์เอง / ลิงก์ภายนอก</span>
                                </label>
                            </div>
                        </div>

                        @if($linkType === 'page')
                            <div>
                                <label class="form-label font-bold text-navy mb-1.5 block">เลือกหน้าเพจปลายทาง *</label>
                                <select wire:model.live="selectedPage" class="form-input text-xs" required>
                                    <option value="">-- กรุณาเลือกหน้าเพจ --</option>
                                    <optgroup label="หน้าหลักของระบบ (System Pages)">
                                        <option value="/">หน้าแรก (Home)</option>
                                        <option value="/about">เกี่ยวกับคณะ (About)</option>
                                        <option value="/about/structure">โครงสร้างองค์กร (Structure)</option>
                                        <option value="/about/management">ผู้บริหารคณะ (Management)</option>
                                        <option value="/about/vision">วิสัยทัศน์และพันธกิจ (Vision)</option>
                                        <option value="/programs">หลักสูตร (Programs)</option>
                                        <option value="/research">วิจัยและนวัตกรรม (Research)</option>
                                        <option value="/services">บริการ (Services)</option>
                                        <option value="/calendar">ปฏิทินกิจกรรม (Calendar)</option>
                                        <option value="/contact">ติดต่อเรา (Contact)</option>
                                    </optgroup>
                                    <optgroup label="หน้าเพจทั่วไปที่คุณสร้างขึ้น (Dynamic Pages)">
                                        @foreach($pages as $page)
                                            <option value="/pages/{{ $page->slug }}">{{ $page->title }} ({{ $page->slug }})</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        @else
                            <div>
                                <label class="form-label font-bold text-navy mb-1.5 block">ที่อยู่ลิงก์เว็บ (URL / Link) *</label>
                                <input type="text" wire:model="url" class="form-input text-xs" placeholder="เช่น /about หรือ https://google.com" required>
                            </div>
                        @endif

                        @if($linkType === 'page' && $url)
                            <div class="bg-teal/5 border border-teal/20 p-2.5 rounded-lg text-[10px] text-teal-dark flex justify-between items-center">
                                <span>🔗 <strong>ลิงก์ปลายทาง:</strong> {{ $url }}</span>
                            </div>
                        @endif

                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">ตำแหน่งของเมนู</label>
                            <select wire:model="location" class="form-select" required>
                                <option value="header">เมนูหลักแถบด้านบน (Header Navigation)</option>
                                <option value="footer_about">ลิงก์เมนูส่วนล่าง - เกี่ยวกับคณะ (Footer About)</option>
                                <option value="footer_programs">ลิงก์เมนูส่วนล่าง - หลักสูตร (Footer Programs)</option>
                                <option value="footer_services">ลิงก์เมนูส่วนล่าง - บริการภายใน (Footer Services)</option>
                            </select>
                        </div>

                        @if($location === 'header')
                            <div>
                                <label class="form-label">เป็นเมนูย่อยภายใต้เมนูหลัก (Parent Menu - ถ้ามี)</label>
                                <select wire:model="parent_id" class="form-select">
                                    <option value="">-- เป็นเมนูหลัก (ไม่มีเมนูแม่) --</option>
                                    @foreach($parentCandidates as $parent1)
                                        <option value="{{ $parent1->id }}">{{ $parent1->title_th }} (ระดับ 1 - เมนูหลัก)</option>
                                        @foreach($parent1->allChildren as $parent2)
                                            @if(!$menuId || $parent2->id !== $menuId)
                                                <option value="{{ $parent2->id }}">&nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $parent2->title_th }} (ระดับ 2 - เมนูย่อย)</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">ลำดับการแสดงผล (Order)</label>
                                <input type="number" wire:model="order" class="form-input" required>
                            </div>

                            <div>
                                <label class="form-label">การเปิดลิงก์ (Target)</label>
                                <select wire:model="target" class="form-select" required>
                                    <option value="_self">เปิดในหน้าเดิม (_self)</option>
                                    <option value="_blank">เปิดในแท็บใหม่ (_blank)</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="active" class="rounded border-border-gray text-teal focus:ring-teal">
                                <span class="text-xs font-bold text-navy">เปิดแสดงผลเมนูนี้สู่ภายนอก</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" wire:click="closeForm()" class="border border-border-gray text-navy px-5 py-2.5 rounded-lg text-xs hover:bg-off cursor-pointer">ยกเลิก</button>
                    <button type="submit" class="btn-primary px-6 py-2.5 cursor-pointer">บันทึกข้อมูลเมนู</button>
                </div>
            </form>
        </div>
    @endif
</div>
