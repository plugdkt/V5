<div>
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-prompt text-sm font-bold text-navy">📅 รายการกิจกรรมในปฏิทินทั้งหมด</h3>
        <button class="btn-primary py-2 px-4 text-xs font-bold opacity-50 cursor-not-allowed" disabled>
            ＋ เพิ่มกิจกรรมใหม่
        </button>
    </div>

    <div class="overflow-hidden border border-border-gray rounded-xl">
        <table class="table w-full text-left text-xs font-light text-navy">
            <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                <tr>
                    <th class="p-4" width="40%">หัวข้อกิจกรรม</th>
                    <th class="p-4" width="20%">หมวดหมู่</th>
                    <th class="p-4" width="20%">วัน/เวลา</th>
                    <th class="p-4" width="20%">สถานที่</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-gray bg-white">
                @forelse($events as $event)
                    <tr class="hover:bg-off/50">
                        <td class="p-4 font-bold text-navy">
                            {{ $event->title }}
                        </td>
                        <td class="p-4">
                            <span class="badge" style="background-color: {{ $event->category->color }}20; color: {{ $event->category->color }}">
                                {{ $event->category->name }}
                            </span>
                        </td>
                        <td class="p-4 text-muted">
                            {{ $event->start_date->locale('th')->translatedFormat('d M y') }}
                        </td>
                        <td class="p-4 text-muted">
                            {{ $event->location ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-muted">ไม่มีกิจกรรมในปฏิทิน</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
