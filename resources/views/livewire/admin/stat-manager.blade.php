<div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-8">
    {{-- List of Recent Stats --}}
    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-border-gray p-5 shadow-sm space-y-4">
            <h3 class="font-prompt text-sm font-bold text-navy border-b border-border-gray pb-2">📈 ข้อมูลสถิติล่าสุดที่บันทึก</h3>
            
            <div class="overflow-hidden border border-border-gray rounded-xl">
                <table class="table w-full text-left text-xs font-light text-navy">
                    <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                        <tr>
                            <th class="p-4" width="40%">บริการ</th>
                            <th class="p-4" width="20%">รอบปี/เดือน</th>
                            <th class="p-4 text-center" width="20%">จำนวนรับบริการ</th>
                            <th class="p-4" width="20%">ผู้บันทึก</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-gray bg-white">
                        @forelse($stats as $st)
                            <tr class="hover:bg-off/50">
                                <td class="p-4 font-bold text-navy">
                                    {{ $st->serviceType->name }}
                                </td>
                                <td class="p-4">
                                    {{ $st->period_year }} / {{ Carbon\Carbon::create(null, $st->period_month, 1)->locale('th')->translatedFormat('F') }}
                                </td>
                                <td class="p-4 text-center font-bold text-navy">
                                    {{ number_format($st->value) }} {{ $st->serviceType->unit }}
                                </td>
                                <td class="p-4 text-muted">
                                    {{ $st->reporter ? $st->reporter->name : 'ระบบ' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-muted">ไม่มีข้อมูลสถิติที่บันทึก</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Stats Entry Form --}}
    <div class="bg-white rounded-2xl border border-border-gray p-6 shadow-sm h-fit">
        <h3 class="font-prompt text-base font-bold text-navy mb-6 pb-2 border-b border-border-gray flex items-center gap-2">
            <span>📝</span> บันทึกสถิติบริการประจำเดือน
        </h3>

        @if($successMessage)
            <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-4">
                {{ $successMessage }}
            </div>
        @endif

        <form wire:submit.prevent="saveStat" class="space-y-4">
            <div>
                <label class="form-label">ประเภทงานบริการ</label>
                <select wire:model="service_type_id" class="form-select" required>
                    @foreach($types as $ty)
                        <option value="{{ $ty->id }}">{{ $ty->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label">ปี พ.ศ. (ค.ศ.)</label>
                    <input type="number" wire:model="period_year" class="form-input" min="2000" max="2100" required>
                </div>
                <div>
                    <label class="form-label">เดือน</label>
                    <select wire:model="period_month" class="form-select" required>
                        <option value="1">มกราคม</option>
                        <option value="2">กุมภาพันธ์</option>
                        <option value="3">มีนาคม</option>
                        <option value="4">เมษายน</option>
                        <option value="5">พฤษภาคม</option>
                        <option value="6">มิถุนายน</option>
                        <option value="7">กรกฎาคม</option>
                        <option value="8">สิงหาคม</option>
                        <option value="9">กันยายน</option>
                        <option value="10">ตุลาคม</option>
                        <option value="11">พฤศจิกายน</option>
                        <option value="12">ธันวาคม</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">ปริมาณ/จำนวนครั้งที่ให้บริการ</label>
                <input type="number" wire:model="value" class="form-input" min="0" required>
            </div>

            <div>
                <label class="form-label">หมายเหตุ / ข้อมูลเพิ่มเติม</label>
                <input type="text" wire:model="note" class="form-input" placeholder="ระบุเพิ่มเติม เช่น ข้อมูลเฉพาะห้องแล็บ">
            </div>

            <button type="submit" class="btn-primary w-full py-3">
                บันทึกตัวเลขสถิติ
            </button>
        </form>
    </div>
</div>
