<div>
    @if(session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-6">
            {{ session('message') }}
        </div>
    @endif

    {{-- Control Bar --}}
    @if(!$isFormOpen)
        <div class="flex justify-between items-center gap-4 mb-6">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input max-w-xs text-xs" placeholder="🔍 ค้นหาชื่อหน้า / URL slug...">
            <button wire:click="openForm()" class="btn-primary py-2 px-4 text-xs font-bold cursor-pointer">
                ＋ สร้างหน้าเพจใหม่
            </button>
        </div>

        {{-- Table List --}}
        <div class="overflow-hidden border border-border-gray rounded-xl">
            <table class="table w-full text-left text-xs font-light text-navy">
                <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                    <tr>
                        <th class="p-4" width="40%">ชื่อหน้าเพจ</th>
                        <th class="p-4" width="30%">ที่อยู่เว็บ (URL Slug)</th>
                        <th class="p-4" width="10%">สถานะ</th>
                        <th class="p-4" width="10%">แก้ไขล่าสุด</th>
                        <th class="p-4 text-center" width="10%">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-gray bg-white">
                    @forelse($pagesList as $p)
                        <tr class="hover:bg-off/50">
                            <td class="p-4">
                                <h4 class="font-bold text-navy text-sm mb-0.5">{{ $p->title }}</h4>
                                <span class="text-[10px] text-muted line-clamp-1">{{ $p->meta_description ?: 'ไม่มีคำอธิบาย' }}</span>
                            </td>
                            <td class="p-4 font-mono text-muted text-[11px]">
                                <a href="/programs/{{ $p->slug }}" target="_blank" class="hover:underline text-teal">
                                    /programs/{{ $p->slug }}
                                </a>
                            </td>
                            <td class="p-4">
                                <span class="badge {{ $p->published ? 'badge-green' : 'badge-amber' }}">
                                    {{ $p->published ? 'เปิดใช้งาน' : 'ซ่อนไว้' }}
                                </span>
                            </td>
                            <td class="p-4 text-muted">
                                {{ $p->updated_at->locale('th')->translatedFormat('d M y') }}
                            </td>
                            <td class="p-4 text-center space-x-1 whitespace-nowrap">
                                <button wire:click="openForm({{ $p->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                    แก้ไข
                                </button>
                                <button onclick="confirm('ยืนยันที่จะลบหน้าเพจนี้หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้') || event.stopImmediatePropagation()" 
                                        wire:click="deletePage({{ $p->id }})" 
                                        class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-muted">ไม่พบข้อมูลหน้าเพจในระบบ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $pagesList->links() }}
        </div>
    @else
        {{-- Form Editor --}}
        <div class="space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $pageId ? '📝 แก้ไขรายละเอียดหน้าเพจ' : '✨ สร้างหน้าเพจใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="savePage" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-[1fr_300px] gap-6">
                    {{-- Main Content --}}
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">หัวข้อ / ชื่อเพจ</label>
                            <input type="text" wire:model.live="title" class="form-input" placeholder="เช่น วิสัยทัศน์และพันธกิจ..." required>
                        </div>

                        <div>
                            <label class="form-label">ที่อยู่ลิงก์เว็บ (URL Slug)</label>
                            <div class="flex">
                                <span class="bg-off border border-r-0 border-border-gray text-muted text-xs px-3 py-2.5 rounded-l-lg flex items-center">/programs/</span>
                                <input type="text" wire:model="slug" class="form-input rounded-l-none" placeholder="vision-and-mission" required>
                            </div>
                            @error('slug') <span class="text-red-600 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="form-label">คำอธิบายหน้าเพจย่อ (SEO Meta Description)</label>
                            <input type="text" wire:model="meta_description" class="form-input" placeholder="คำอธิบายสั้น ๆ สำหรับแสดงบนหน้าค้นหา Google...">
                        </div>

                        <div>
                            <label class="form-label">แนบไฟล์เอกสาร PDF เพื่อแสดงผลในเพจ (ถ้ามี)</label>
                            <div class="flex gap-2">
                                <input type="text" id="pdf_path_input" wire:model="pdf_path" class="form-input" placeholder="เช่น /storage/medsci_doc/plan/69/plan_2569-2573.pdf">
                                <button type="button" onclick="openPdfPicker()" class="bg-teal text-white px-4 py-2.5 text-xs font-bold rounded-lg hover:bg-teal-dark cursor-pointer whitespace-nowrap">
                                    📂 เลือกจากคลังสื่อ
                                </button>
                            </div>
                            <p class="text-[10px] text-muted mt-1">หากใส่ลิงก์ไฟล์ PDF ระบบจะแสดงผลเอกสาร PDF และการ์ดดาวน์โหลดที่หน้าเพจโดยอัตโนมัติ ไม่ต้องพิมพ์โค้ดเอง</p>
                        </div>


                        <div>
                            <label class="form-label">รายละเอียดเนื้อหาเพจ (Rich Text Editor / TinyMCE)</label>
                            <div wire:ignore 
                                 x-data="{ 
                                     value: @entangle('body'),
                                     init() {
                                         tinymce.init({
                                             target: this.$refs.editor,
                                             height: 450,
                                             menubar: true,
                                             plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                                             toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | table code | link image media',
                                             file_picker_callback: function (callback, value, meta) {
                                                 tinymce.activeEditor.windowManager.openUrl({
                                                     title: 'คลังรูปภาพและไฟล์อัปโหลด (Media Browser)',
                                                     url: '{{ route('admin.media.picker') }}',
                                                     width: 850,
                                                     height: 600,
                                                     onMessage: function (api, data) {
                                                         if (data.mceAction === 'selectFile') {
                                                             callback(data.url, { text: data.url });
                                                             api.close();
                                                         }
                                                     }
                                                 });
                                             },
                                             setup: (editor) => {
                                                 editor.on('change', () => {
                                                     this.value = editor.getContent();
                                                 });
                                                 editor.on('init', () => {
                                                     editor.setContent(this.value || '');
                                                 });
                                                 this.$watch('value', (newValue) => {
                                                     if (newValue !== editor.getContent()) {
                                                         editor.setContent(newValue || '');
                                                     }
                                                 });
                                             }
                                         });

                                     }
                                 }">
                                <textarea x-ref="editor" class="form-input"></textarea>
                            </div>
                        </div>
                    </div>


                    {{-- Sidebar Settings --}}
                    <div class="space-y-4 bg-off p-5 border border-border-gray rounded-2xl h-fit">
                        <h4 class="font-prompt text-xs font-bold text-navy border-b border-border-gray pb-2">⚙️ ตั้งค่าเพจ</h4>

                        <div>
                            <label class="flex items-center gap-2 cursor-pointer py-2">
                                <input type="checkbox" wire:model="published" class="rounded border-border-gray text-teal focus:ring-teal">
                                <span class="text-xs font-bold text-navy">เปิดเผยแพร่หน้านี้ทันที</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 mt-6">
                            💾 บันทึกข้อมูลหน้าเพจ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <script>
        function openPdfPicker() {
            const width = 850;
            const height = 600;
            const left = (screen.width - width) / 2;
            const top = (screen.height - height) / 2;
            window.open('{{ route('admin.media.picker') }}', 'PdfPicker', `width=${width},height=${height},left=${left},top=${top},scrollbars=yes`);
        }

        window.selectPdfPath = function(url) {
            const input = document.getElementById('pdf_path_input');
            if (input) {
                input.value = url;
                input.dispatchEvent(new Event('input'));
            }
        };


    </script>
</div>

