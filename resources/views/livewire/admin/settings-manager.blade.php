<div>
    @if($successMessage)
        <div class="bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl p-4 mb-6">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit.prevent="saveSettings" class="space-y-6">
        {{-- Section 1: General Info --}}
        <div class="bg-off p-5 border border-border-gray rounded-2xl space-y-4">
            <h3 class="font-prompt text-sm font-bold text-navy border-b border-border-gray pb-2">🏢 ข้อมูลองค์กรเบื้องต้น</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">ชื่อคณะ (ภาษาไทย)</label>
                    <input type="text" wire:model="site_name_th" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">ชื่อคณะ (ภาษาอังกฤษ)</label>
                    <input type="text" wire:model="site_name_en" class="form-input" required>
                </div>
            </div>
        </div>

        {{-- Section 2: Contact Info --}}
        <div class="bg-off p-5 border border-border-gray rounded-2xl space-y-4">
            <h3 class="font-prompt text-sm font-bold text-navy border-b border-border-gray pb-2">📞 ข้อมูลการติดต่อ</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="form-label">เบอร์โทรศัพท์</label>
                    <input type="text" wire:model="contact_phone" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">อีเมลกลาง</label>
                    <input type="email" wire:model="contact_email" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">ที่อยู่คณะ</label>
                    <input type="text" wire:model="contact_address" class="form-input" required>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">ลิงก์ Facebook Page</label>
                    <input type="url" wire:model="social_facebook" class="form-input">
                </div>
                <div>
                    <label class="form-label">ลิงก์ YouTube Channel</label>
                    <input type="url" wire:model="social_youtube" class="form-input">
                </div>
            </div>
        </div>

        {{-- Section 3: Homepage Stats --}}
        <div class="bg-off p-5 border border-border-gray rounded-2xl space-y-4">
            <h3 class="font-prompt text-sm font-bold text-navy border-b border-border-gray pb-2">📊 ตัวเลขสถิติบนหน้าเว็บหลัก (Stats Band)</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="form-label">ปีแห่งการก่อตั้ง (ปี)</label>
                    <input type="number" wire:model="stat_years" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">อาจารย์และบุคลากร (คน)</label>
                    <input type="number" wire:model="stat_staff" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">ศิษย์เก่าสำเร็จการศึกษา (คน)</label>
                    <input type="number" wire:model="stat_alumni" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">ผลงานวิจัยตีพิมพ์ (เรื่อง)</label>
                    <input type="number" wire:model="stat_research" class="form-input" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary py-3 px-6 cursor-pointer">
            💾 บันทึกการตั้งค่าทั้งหมด
        </button>
    </form>
</div>
