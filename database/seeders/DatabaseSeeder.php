<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Banner;
use App\Models\Page;
use App\Models\NewsCategory;
use App\Models\MeetingRoom;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Super Admin User (for local testing, actual users will login via SSO)
        User::updateOrCreate(
            ['email' => 'admin@medsci.up.ac.th'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('AdminMedSci2026@'),
                'role' => 'super_admin',
                'active' => true,
                'employee_id' => '000000',
            ]
        );

        User::updateOrCreate(
            ['email' => 'wittaya.su@up.ac.th'],
            [
                'name' => 'Wittaya Su',
                'role' => 'super_admin',
                'active' => true,
                'employee_id' => '112233',
            ]
        );

        // 2. Initial Settings
        Setting::set('site_name_th', 'คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา', 'string', 'general');
        Setting::set('site_name_en', 'School of Medical Sciences, University of Phayao', 'string', 'general');
        Setting::set('contact_address', '19 หมู่ 2 ต.แม่กา อ.เมือง จ.พะเยา 56000', 'string', 'contact');
        Setting::set('contact_phone', '054-466-666 ต่อ 3811', 'string', 'contact');
        Setting::set('contact_email', 'medsci@up.ac.th', 'string', 'contact');
        Setting::set('social_facebook', 'https://www.facebook.com/medsci.up', 'string', 'contact');
        Setting::set('social_youtube', 'https://www.youtube.com', 'string', 'contact');
        Setting::set('apply_link', 'https://reg.up.ac.th', 'string', 'general');

        // 3. Default Banners
        Banner::updateOrCreate(
            ['image' => 'assets/images/banners/banner1.jpg'],
            [
                'title' => 'ยินดีต้อนรับสู่คณะวิทยาศาสตร์การแพทย์',
                'link' => '#',
                'order' => 1,
                'active' => true
            ]
        );

        // 4. Default Static Pages
        Page::updateOrCreate(
            ['slug' => 'history'],
            [
                'title' => 'ประวัติความเป็นมา',
                'body' => '<h3>ประวัติความเป็นมาของคณะวิทยาศาสตร์การแพทย์</h3><p>คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา ก่อตั้งขึ้นเพื่อมุ่งเน้นการผลิตบัณฑิตด้านวิทยาศาสตร์การแพทย์...</p>',
                'meta_description' => 'ประวัติความเป็นมา คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา',
                'published' => true
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'vision'],
            [
                'title' => 'วิสัยทัศน์ / พันธกิจ',
                'body' => '<h3>วิสัยทัศน์</h3><p>แหล่งปัญญาด้านวิทยาศาสตร์การแพทย์ระดับอาเซียน ภายในปี 2575</p><h3>พันธกิจ</h3><p>1. ผลิตบัณฑิตที่มีคุณภาพและคุณธรรม<br>2. ขับเคลื่อนผลงานวิจัยนวัตกรรมในระดับชาติและสากล</p>',
                'meta_description' => 'วิสัยทัศน์และพันธกิจ คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา',
                'published' => true
            ]
        );

        // 5. Default News Categories
        NewsCategory::updateOrCreate(
            ['slug' => 'general'],
            ['name_th' => 'ข่าวประชาสัมพันธ์', 'name_en' => 'General Announcement', 'color' => '#1B6CA8', 'icon' => 'ti-announcement', 'order' => 1]
        );
        NewsCategory::updateOrCreate(
            ['slug' => 'activity'],
            ['name_th' => 'ข่าวกิจกรรม', 'name_en' => 'Activities', 'color' => '#C9A84C', 'icon' => 'ti-calendar', 'order' => 2]
        );
        NewsCategory::updateOrCreate(
            ['slug' => 'procurement'],
            ['name_th' => 'ข่าวจัดซื้อจัดจ้าง', 'name_en' => 'Procurement', 'color' => '#EF4444', 'icon' => 'ti-file', 'order' => 3]
        );

        // 6. Default Meeting Rooms
        MeetingRoom::updateOrCreate(
            ['name' => 'ห้องประชุมศาสตราจารย์พิเศษ ดร.มณฑล สงวนเสริมศรี'],
            [
                'capacity' => 50,
                'location' => 'อาคารปฏิบัติการ คณะวิทยาศาสตร์การแพทย์ ชั้น 1',
                'description' => 'ห้องประชุมใหญ่ อุปกรณ์ครบครัน ระบบเครื่องเสียงทันสมัย',
                'amenities' => ['projector', 'microphone', 'sound_system', 'wifi'],
                'active' => true
            ]
        );
        MeetingRoom::updateOrCreate(
            ['name' => 'ห้องประชุมบุศราคัม (ห้องประชุมย่อย)'],
            [
                'capacity' => 15,
                'location' => 'อาคารปฏิบัติการ คณะวิทยาศาสตร์การแพทย์ ชั้น 2',
                'description' => 'ห้องประชุมขนาดเล็ก เหมาะสำหรับการประชุมกลุ่มย่อย',
                'amenities' => ['smart_tv', 'microphone', 'wifi'],
                'active' => true
            ]
        );
        MeetingRoom::updateOrCreate(
            ['name' => 'Co-Learning Space'],
            [
                'capacity' => 30,
                'location' => 'อาคารปฏิบัติการ คณะวิทยาศาสตร์การแพทย์ ชั้น 1',
                'description' => 'พื้นที่ทำงานกลุ่มสำหรับนิสิต คณะวิทยาศาสตร์การแพทย์',
                'amenities' => ['whiteboard', 'smart_tv', 'wifi'],
                'active' => true
            ]
        );

        // 7. Default Service Types
        ServiceType::updateOrCreate(
            ['name' => 'บริการวิเคราะห์สิ่งส่งตรวจทางห้องปฏิบัติการ'],
            ['unit' => 'ตัวอย่าง', 'description' => 'บริการตรวจวิเคราะห์ตัวอย่างสิ่งส่งตรวจจากโรงพยาบาลและหน่วยงานภายนอก', 'category' => 'laboratory', 'active' => true]
        );
        ServiceType::updateOrCreate(
            ['name' => 'บริการตรวจวิเคราะห์น้ำดื่มน้ำใช้'],
            ['unit' => 'ตัวอย่าง', 'description' => 'บริการตรวจวิเคราะห์คุณภาพทางเคมีและชีวภาพของน้ำดื่มน้ำใช้', 'category' => 'laboratory', 'active' => true]
        );
        ServiceType::updateOrCreate(
            ['name' => 'บริการวิชาการ/อบรมวิชาชีพ'],
            ['unit' => 'ครั้ง', 'description' => 'บริการอบรมให้ความรู้แก่ชุมชนและหน่วยงานต่างๆ', 'category' => 'academic', 'active' => true]
        );
    }
}
