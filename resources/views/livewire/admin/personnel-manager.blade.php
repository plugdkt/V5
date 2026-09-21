<div>
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-prompt text-sm font-bold text-navy">👥 ทำเนียบบุคลากรทั้งหมด</h3>
        <button class="btn-primary py-2 px-4 text-xs font-bold opacity-50 cursor-not-allowed" disabled>
            ＋ เพิ่มบุคลากรใหม่
        </button>
    </div>

    <div class="overflow-hidden border border-border-gray rounded-xl">
        <table class="table w-full text-left text-xs font-light text-navy">
            <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                <tr>
                    <th class="p-4" width="10%">รูป</th>
                    <th class="p-4" width="30%">ชื่อ-นามสกุล</th>
                    <th class="p-4" width="30%">สาขาวิชา/ฝ่ายงาน</th>
                    <th class="p-4" width="20%">ตำแหน่ง</th>
                    <th class="p-4" width="10%">สถานะ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-gray bg-white">
                @forelse($personnel as $person)
                    <tr class="hover:bg-off/50">
                        <td class="p-4">
                            <div class="w-9 h-9 rounded-full bg-teal/5 border border-border-gray overflow-hidden flex items-center justify-center">
                                @if($person->photo)
                                    <img src="{{ asset($person->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-teal/40 font-bold font-prompt text-sm">{{ mb_substr($person->firstname_th, 0, 1) }}</div>
                                @endif
                            </div>
                        </td>
                        <td class="p-4 font-bold text-navy">
                            {{ $person->full_name_th }}
                            @if($person->academic_position)
                                <span class="block text-[10px] text-gold font-semibold mt-0.5">{{ $person->academic_position }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-muted">
                            {{ $person->department ? $person->department->name_th : '-' }}
                        </td>
                        <td class="p-4 text-muted">
                            {{ $person->position ? $person->position->name_th : '-' }}
                        </td>
                        <td class="p-4">
                            <span class="badge badge-green">ปกติ</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-muted">ไม่มีข้อมูลบุคลากรในระบบ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
