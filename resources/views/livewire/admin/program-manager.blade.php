<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-prompt text-lg font-bold text-navy">🎓 จัดการหลักสูตรการศึกษา</h2>
        @if(!$isFormOpen)
            <button wire:click="openForm()" class="bg-gold text-navy font-bold px-4 py-2 text-xs rounded-lg hover:bg-gold-light cursor-pointer shadow-md shadow-gold/10">
                ➕ เพิ่มหลักสูตรใหม่
            </button>
        @endif
    </div>

    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-xs mb-6">
            {{ session('message') }}
        </div>
    @endif

    @if(!$isFormOpen)
        {{-- Search & Table List --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-4 space-y-4">
            <div class="flex gap-2">
                <input type="text" wire:model.live="search" class="form-input text-xs" placeholder="ค้นหาชื่อหลักสูตร...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-border-gray text-navy font-bold">
                            <th class="p-3 w-16 text-center">ลำดับ</th>
                            <th class="p-3 w-32 text-center">ภาพ Hero</th>
                            <th class="p-3">ชื่อหลักสูตร (ไทย)</th>
                            <th class="p-3">ชื่อหลักสูตร (English)</th>
                            <th class="p-3 w-24 text-center">หน่วยกิต</th>
                            <th class="p-3 w-24 text-center">สถานะ</th>
                            <th class="p-3 w-32 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray text-navy">
                        @forelse($programsList as $pr)
                            <tr class="hover:bg-off/50">
                                <td class="p-3 text-center font-bold">
                                    {{ $pr->sort_order }}
                                </td>
                                <td class="p-3 text-center">
                                    @if($pr->hero_image)
                                        <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $pr->hero_image), '/')) }}" class="w-24 h-12 object-cover rounded border border-border-gray mx-auto">
                                    @else
                                        <div class="w-24 h-12 rounded border border-border-dashed border-border-gray bg-off flex items-center justify-center text-[10px] text-muted mx-auto">
                                            ไม่มีรูปภาพ
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3 font-semibold">
                                    {{ $pr->title_th }}
                                </td>
                                <td class="p-3 text-muted">
                                    {{ $pr->title_en }}
                                </td>
                                <td class="p-3 text-center font-bold text-teal">
                                    {{ $pr->credits }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[9px] {{ $pr->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $pr->is_active ? 'เปิดใช้งาน' : 'ปิดการใช้งาน' }}
                                    </span>
                                </td>
                                <td class="p-3 text-center space-x-1 whitespace-nowrap">
                                    <button wire:click="openForm({{ $pr->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                        แก้ไข
                                    </button>
                                    <button onclick="confirm('ยืนยันที่จะลบหลักสูตรนี้หรือไม่? ข้อมูลหลักสูตรทั้งหมดจะสูญหายถาวร!') || event.stopImmediatePropagation()" 
                                            wire:click="deleteProgram({{ $pr->id }})" 
                                            class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                        ลบ
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-10 text-center text-muted">ไม่พบข้อมูลหลักสูตรการศึกษาในระบบ</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $programsList->links() }}
            </div>
        </div>
    @else
        {{-- Form Editor --}}
        <div class="bg-white rounded-2xl border border-border-gray shadow-sm p-6 space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $programId ? '📝 แก้ไขหลักสูตรการศึกษา' : '✨ เพิ่มหลักสูตรการศึกษาใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="saveProgram" class="space-y-6 text-xs text-navy">
                
                {{-- SECTION 1: Basic Info --}}
                <div class="bg-off/40 rounded-xl p-4 border border-border-gray space-y-4">
                    <h4 class="font-prompt text-xs font-bold text-teal uppercase tracking-wider flex items-center gap-1.5">
                        <span>1.</span> ข้อมูลพื้นฐานหลักสูตร
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">ชื่อหลักสูตร (ภาษาไทย) *</label>
                            <input type="text" wire:model.blur="title_th" class="form-input" placeholder="เช่น หลักสูตรวิทยาศาสตรบัณฑิต..." required>
                        </div>
                        <div>
                            <label class="form-label">ชื่อหลักสูตร (ภาษาอังกฤษ) *</label>
                            <input type="text" wire:model="title_en" class="form-input" placeholder="เช่น Bachelor of Science Program in..." required>
                        </div>
                        <div>
                            <label class="form-label">URL Slug *</label>
                            <input type="text" wire:model="slug" class="form-input" placeholder="เช่น microbiology" required>
                            @error('slug') <span class="text-red-500 block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="form-label">จำนวนหน่วยกิตรวม *</label>
                            <input type="number" wire:model="credits" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">ระยะเวลาการศึกษา (ปี) *</label>
                            <input type="number" wire:model="duration_years" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">ค่าธรรมเนียมต่อเทอม (บาท) *</label>
                            <input type="number" wire:model="fee_per_semester" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">หลักสูตรปี พ.ศ. *</label>
                            <input type="text" wire:model="curriculum_year" class="form-input" placeholder="เช่น 2565" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">ลำดับการเรียงลำดับ *</label>
                            <input type="number" wire:model="sort_order" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">สถานะการแสดงผล *</label>
                            <select wire:model="is_active" class="form-select" required>
                                <option value="1">เปิดใช้งาน (Active)</option>
                                <option value="0">ปิดใช้งาน (Inactive)</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Degrees --}}
                <div class="bg-off/40 rounded-xl p-4 border border-border-gray space-y-4">
                    <h4 class="font-prompt text-xs font-bold text-teal uppercase tracking-wider flex items-center gap-1.5">
                        <span>2.</span> ชื่อปริญญาและอักษรย่อ
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">ชื่อปริญญาเต็ม (ไทย) *</label>
                            <input type="text" wire:model="degree_full_th" class="form-input" placeholder="เช่น วิทยาศาสตรบัณฑิต (จุลชีววิทยา)" required>
                        </div>
                        <div>
                            <label class="form-label">ตัวย่อปริญญา (ไทย) *</label>
                            <input type="text" wire:model="degree_abbr_th" class="form-input" placeholder="เช่น วท.บ. (จุลชีววิทยา)" required>
                        </div>
                        <div>
                            <label class="form-label">ชื่อปริญญาเต็ม (อังกฤษ) *</label>
                            <input type="text" wire:model="degree_full_en" class="form-input" placeholder="เช่น Bachelor of Science (Microbiology)" required>
                        </div>
                        <div>
                            <label class="form-label">ตัวย่อปริญญา (อังกฤษ) *</label>
                            <input type="text" wire:model="degree_abbr_en" class="form-input" placeholder="เช่น B.Sc. (Microbiology)" required>
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: Banner & Branding --}}
                <div class="bg-off/40 rounded-xl p-4 border border-border-gray space-y-4">
                    <h4 class="font-prompt text-xs font-bold text-teal uppercase tracking-wider flex items-center gap-1.5">
                        <span>3.</span> ภาพ Hero & สีแบรนดิ้ง
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">ภาพแบนเนอร์ Hero (เก็บในสื่อมีเดีย)</label>
                            <div class="flex gap-2">
                                <input type="text" id="program_image_input" wire:model="hero_image" class="form-input" placeholder="เช่น media/microbiology_hero.png">
                                <button type="button" onclick="openProgramPhotoPicker()" class="bg-teal text-white px-4 py-2 font-bold rounded-lg hover:bg-teal-dark cursor-pointer whitespace-nowrap">
                                    📂 เลือกรูปภาพ
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">สีแบนเนอร์ซ้าย (Gradient From) *</label>
                            <div class="flex gap-2 items-center">
                                <input type="color" wire:model="hero_color_from" class="w-10 h-8 border rounded cursor-pointer">
                                <input type="text" wire:model="hero_color_from" class="form-input flex-grow" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">สีแบนเนอร์ขวา (Gradient To) *</label>
                            <div class="flex gap-2 items-center">
                                <input type="color" wire:model="hero_color_to" class="w-10 h-8 border rounded cursor-pointer">
                                <input type="text" wire:model="hero_color_to" class="form-input flex-grow" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: Overview --}}
                <div class="bg-off/40 rounded-xl p-4 border border-border-gray space-y-4">
                    <h4 class="font-prompt text-xs font-bold text-teal uppercase tracking-wider flex items-center gap-1.5">
                        <span>4.</span> ภาพรวมหลักสูตร
                    </h4>
                    <div>
                        <label class="form-label">เนื้อหาภาพรวมหลักสูตร</label>
                        <textarea wire:model="overview" class="form-input min-h-[120px]" placeholder="รายละเอียดความเป็นมา ภาพรวม และความสำคัญของหลักสูตร..."></textarea>
                    </div>
                </div>

                {{-- SECTION 5: Expected Learning Outcomes (PLOs) --}}
                <div class="bg-off/40 rounded-xl p-4 border border-border-gray space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-prompt text-xs font-bold text-teal uppercase tracking-wider flex items-center gap-1.5">
                            <span>5.</span> ผลการเรียนรู้ที่คาดหวัง (PLOs)
                        </h4>
                        <button type="button" wire:click="addPlo" class="bg-teal text-white px-2.5 py-1 rounded font-bold hover:bg-teal-dark cursor-pointer text-[10px]">
                            ➕ เพิ่มแถว PLO
                        </button>
                    </div>

                    <div class="space-y-2">
                        @foreach($plos_input as $index => $plo)
                            <div class="flex gap-2 items-start bg-white p-3 rounded-lg border border-border-gray shadow-sm">
                                <div class="w-20">
                                    <input type="text" wire:model="plos_input.{{ $index }}.code" class="form-input text-center font-bold text-navy" placeholder="เช่น PLO1" required>
                                </div>
                                <div class="flex-grow">
                                    <input type="text" wire:model="plos_input.{{ $index }}.description" class="form-input" placeholder="ระบุผลการเรียนรู้" required>
                                </div>
                                <div>
                                    <button type="button" wire:click="removePlo({{ $index }})" class="bg-red-50 text-red-600 px-2 py-2 rounded-lg hover:bg-red-100 cursor-pointer">
                                        ลบ
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- SECTION 6: Curriculum by Year --}}
                <div class="bg-off/40 rounded-xl p-4 border border-border-gray space-y-4">
                    <h4 class="font-prompt text-xs font-bold text-teal uppercase tracking-wider flex items-center gap-1.5">
                        <span>6.</span> รายละเอียดการเรียนการสอนรายปี (Curriculum Year 1-4)
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label font-bold">ชั้นปีที่ 1</label>
                            <textarea wire:model="curriculum_year1" class="form-input min-h-[100px]" placeholder="วิชาการเรียนการสอน ชั้นปีที่ 1..."></textarea>
                        </div>
                        <div>
                            <label class="form-label font-bold">ชั้นปีที่ 2</label>
                            <textarea wire:model="curriculum_year2" class="form-input min-h-[100px]" placeholder="วิชาการเรียนการสอน ชั้นปีที่ 2..."></textarea>
                        </div>
                        <div>
                            <label class="form-label font-bold">ชั้นปีที่ 3</label>
                            <textarea wire:model="curriculum_year3" class="form-input min-h-[100px]" placeholder="วิชาการเรียนการสอน ชั้นปีที่ 3..."></textarea>
                        </div>
                        <div>
                            <label class="form-label font-bold">ชั้นปีที่ 4</label>
                            <textarea wire:model="curriculum_year4" class="form-input min-h-[100px]" placeholder="วิชาการเรียนการสอน ชั้นปีที่ 4..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- SECTION 7: Careers --}}
                <div class="bg-off/40 rounded-xl p-4 border border-border-gray space-y-4">
                    <div class="flex justify-between items-center">
                        <h4 class="font-prompt text-xs font-bold text-teal uppercase tracking-wider flex items-center gap-1.5">
                            <span>7.</span> อาชีพหลังสำเร็จการศึกษา
                        </h4>
                        <button type="button" wire:click="addCareer" class="bg-teal text-white px-2.5 py-1 rounded font-bold hover:bg-teal-dark cursor-pointer text-[10px]">
                            ➕ เพิ่มแถวอาชีพ
                        </button>
                    </div>

                    <div class="space-y-2">
                        @foreach($careers_input as $index => $car)
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-start bg-white p-3 rounded-lg border border-border-gray shadow-sm">
                                <div class="md:col-span-1">
                                    <label class="form-label md:hidden">Icon</label>
                                    <input type="text" wire:model="careers_input.{{ $index }}.icon" class="form-input text-center text-lg" placeholder="เช่น 🔬" required>
                                </div>
                                <div class="md:col-span-3">
                                    <label class="form-label md:hidden">ชื่ออาชีพ</label>
                                    <input type="text" wire:model="careers_input.{{ $index }}.title" class="form-input font-bold" placeholder="เช่น นักวิจัย" required>
                                </div>
                                <div class="md:col-span-7">
                                    <label class="form-label md:hidden">รายละเอียด</label>
                                    <input type="text" wire:model="careers_input.{{ $index }}.description" class="form-input" placeholder="คำอธิบายสั้นๆ" required>
                                </div>
                                <div class="md:col-span-1 text-right">
                                    <button type="button" wire:click="removeCareer({{ $index }})" class="bg-red-50 text-red-600 px-2 py-2 rounded-lg hover:bg-red-100 cursor-pointer mt-1 md:mt-0">
                                        ลบ
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex justify-end gap-2 border-t border-border-gray pt-4">
                    <button type="button" wire:click="closeForm()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-200 cursor-pointer">
                        ✕ ยกเลิก
                    </button>
                    <button type="submit" class="bg-gold text-navy px-6 py-2 rounded-lg font-bold hover:bg-gold-light cursor-pointer shadow-md shadow-gold/10">
                        💾 บันทึกข้อมูลหลักสูตร
                    </button>
                </div>
            </form>
        </div>
    @endif

    <script>
        function openProgramPhotoPicker() {
            const width = 850;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            window.open('{{ route('admin.media.picker') }}', 'ProgramPhotoPicker', `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`);
        }

        window.selectPdfPath = function(url) {
            const programInput = document.getElementById('program_image_input');
            if (programInput) {
                let path = url;
                if (path.includes('/storage/')) {
                    path = path.split('/storage/')[1];
                } else if (path.includes('storage/')) {
                    path = path.split('storage/')[1];
                }
                path = path.replace(/^\/+/, '');
                
                programInput.value = path;
                programInput.dispatchEvent(new Event('input'));
            }
        };
    </script>
</div>
