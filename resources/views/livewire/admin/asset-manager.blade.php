<div>
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-prompt text-sm font-bold text-navy">📦 ทะเบียนพัสดุครุภัณฑ์ทั้งหมด</h3>
        <button class="btn-primary py-2 px-4 text-xs font-bold opacity-50 cursor-not-allowed" disabled>
            ＋ เพิ่มครุภัณฑ์ใหม่
        </button>
    </div>

    <div class="overflow-hidden border border-border-gray rounded-xl">
        <table class="table w-full text-left text-xs font-light text-navy">
            <thead class="bg-off font-prompt font-bold text-navy border-b border-border-gray">
                <tr>
                    <th class="p-4" width="25%">รหัสครุภัณฑ์</th>
                    <th class="p-4" width="35%">รายการพัสดุ</th>
                    <th class="p-4" width="20%">หมวดหมู่</th>
                    <th class="p-4" width="10%">สภาพ</th>
                    <th class="p-4" width="10%">สถานะ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-gray bg-white">
                @forelse($assets as $asset)
                    <tr class="hover:bg-off/50">
                        <td class="p-4 font-bold text-navy">
                            {{ $asset->asset_code ?? '-' }}
                        </td>
                        <td class="p-4">
                            <h4 class="font-bold text-navy text-sm mb-0.5">{{ $asset->name }}</h4>
                            @if($asset->serial_number)
                                <span class="text-muted text-[10px] block">S/N: {{ $asset->serial_number }}</span>
                            @endif
                        </td>
                        <td class="p-4 text-muted">
                            {{ $asset->category->name }}
                        </td>
                        <td class="p-4 text-muted capitalize">
                            {{ $asset->condition }}
                        </td>
                        <td class="p-4">
                            <span class="badge badge-green">พร้อมใช้งาน</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-muted">ไม่มีข้อมูลพัสดุครุภัณฑ์ในระบบ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
