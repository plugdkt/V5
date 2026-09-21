<div>
    @if(session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-6">
            {{ session('message') }}
        </div>
    @endif

    {{-- Control Bar --}}
    @if(!$isFormOpen)
        <div class="flex justify-between items-center gap-4 mb-6">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input max-w-xs text-xs" placeholder="🔍 ค้นหาหัวข้อข่าว...">
            <button wire:click="openForm()" class="btn-primary py-2 px-4 text-xs font-bold cursor-pointer">
                ＋ เขียนข่าวใหม่
            </button>
        </div>

        {{-- Table List --}}
        <div class="overflow-hidden border border-border-gray rounded-xl">
            <table class="table w-full text-left text-xs font-light text-navy">
                <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                    <tr>
                        <th class="p-4" width="8%">รูปภาพ</th>
                        <th class="p-4" width="47%">หัวข้อข่าว</th>
                        <th class="p-4" width="15%">หมวดหมู่</th>
                        <th class="p-4" width="10%">สถานะ</th>
                        <th class="p-4" width="10%">วันที่เผยแพร่</th>
                        <th class="p-4 text-center" width="10%">การจัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-gray bg-white">
                    @forelse($articles as $art)
                        <tr class="hover:bg-off/50">
                            <td class="p-4">
                                <div class="w-12 h-12 rounded-lg bg-teal/5 overflow-hidden border border-border-gray">
                                    @if($art->cover_image)
                                        <img src="{{ asset('storage/' . $art->cover_image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-teal/40 font-bold font-prompt text-lg">M</div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <h4 class="font-bold text-navy text-sm mb-0.5 line-clamp-1">{{ $art->title_th }}</h4>
                                <span class="text-[10px] text-muted">👁️ เข้าชมแล้ว: {{ $art->view_count }} ครั้ง</span>
                            </td>
                            <td class="p-4">
                                <span class="badge" style="background-color: {{ $art->category->color }}20; color: {{ $art->category->color }}">
                                    {{ $art->category->name_th }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="badge {{ $art->status === 'published' ? 'badge-green' : 'badge-amber' }}">
                                    {{ $art->status === 'published' ? 'เผยแพร่แล้ว' : 'ฉบับร่าง' }}
                                </span>
                            </td>
                            <td class="p-4 text-muted">
                                {{ $art->published_at ? $art->published_at->locale('th')->translatedFormat('d M y') : '-' }}
                            </td>
                            <td class="p-4 text-center space-x-1 whitespace-nowrap">
                                <button wire:click="openForm({{ $art->id }})" class="bg-teal text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-teal-dark cursor-pointer">
                                    แก้ไข
                                </button>
                                <button onclick="confirm('ยืนยันที่จะลบข่าวนี้หรือไม่?') || event.stopImmediatePropagation()" 
                                        wire:click="deleteArticle({{ $art->id }})" 
                                        class="bg-red-100 text-red-600 px-2.5 py-1.5 rounded-lg font-bold hover:bg-red-200 cursor-pointer">
                                    ลบ
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-muted">ไม่พบข้อมูลข่าวสารประชาสัมพันธ์</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    @else
        {{-- Form Editor --}}
        <div class="space-y-6">
            <div class="flex justify-between items-center border-b border-border-gray pb-4">
                <h3 class="font-prompt text-base font-bold text-navy">
                    {{ $articleId ? '📝 แก้ไขข่าวสารประชาสัมพันธ์' : '✨ เขียนข่าวประชาสัมพันธ์ใหม่' }}
                </h3>
                <button wire:click="closeForm()" class="text-xs text-muted hover:text-navy cursor-pointer">✕ ยกเลิก</button>
            </div>

            <form wire:submit.prevent="saveArticle" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-[1fr_250px] gap-6">
                    {{-- Main columns --}}
                    <div class="space-y-4">
                        <div>
                            <label class="form-label">หัวข้อข่าว (ภาษาไทย)</label>
                            <input type="text" wire:model="title_th" class="form-input" placeholder="กรอกหัวข้อข่าวสาร..." required>
                        </div>

                        <div>
                            <label class="form-label">หัวข้อข่าว (ภาษาอังกฤษ - ถ้ามี)</label>
                            <input type="text" wire:model="title_en" class="form-input" placeholder="News Title (English)...">
                        </div>

                        <div>
                            <label class="form-label">เนื้อหาข่าวประชาสัมพันธ์ (บทสรุปย่อ/คำโปรย)</label>
                            <textarea wire:model="excerpt" rows="2" class="form-input" placeholder="คำโปรยสั้น ๆ หรือรายละเอียดเบื้องต้น..."></textarea>
                        </div>

                        <div>
                            <label class="form-label">รายละเอียดเนื้อหาข่าว (Rich Text Editor / TinyMCE)</label>
                            <div wire:ignore 
                                 x-data="{ 
                                     value: @entangle('body'),
                                     init() {
                                         tinymce.init({
                                             target: this.$refs.editor,
                                             height: 400,
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


                    {{-- Sidebar settings --}}
                    <div class="space-y-4 bg-off p-5 border border-border-gray rounded-2xl h-fit">
                        <div>
                            <label class="form-label">หมวดหมู่ข่าว</label>
                            <select wire:model="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name_th }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">สถานะการเผยแพร่</label>
                            <select wire:model="status" class="form-select" required>
                                <option value="draft">ฉบับร่าง (Draft)</option>
                                <option value="published">เผยแพร่ทันที (Published)</option>
                            </select>
                        </div>

                        @if($status === 'published')
                            <div>
                                <label class="form-label">วันที่/เวลาเผยแพร่</label>
                                <input type="datetime-local" wire:model="published_at" class="form-input">
                            </div>
                        @endif

                        <div>
                            <label class="form-label">ภาพหน้าปกข่าว</label>
                            <input type="file" wire:model="cover_image" class="form-input text-xs py-1.5 px-3">
                            <div wire:loading wire:target="cover_image" class="text-[10px] text-teal block mt-1">⏳ กำลังอัปโหลด...</div>
                            
                            {{-- Preview cover --}}
                            <div class="mt-4">
                                @if($cover_image)
                                    <span class="text-[10px] text-muted block mb-1">พรีวิวรูปภาพใหม่:</span>
                                    <img src="{{ $cover_image->temporaryUrl() }}" class="w-full h-24 rounded-lg object-cover border border-border-gray">
                                @elseif($existing_cover_image)
                                    <span class="text-[10px] text-muted block mb-1">รูปภาพหน้าปกปัจจุบัน:</span>
                                    <img src="{{ asset('storage/' . $existing_cover_image) }}" class="w-full h-24 rounded-lg object-cover border border-border-gray">
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn-primary w-full py-3 mt-6">
                            💾 บันทึกข้อมูลข่าว
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>
