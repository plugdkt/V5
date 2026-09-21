<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EService;

class EServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Student E-Services
        EService::create([
            'title' => 'ระบบบริการการศึกษา',
            'description' => 'ลงทะเบียนเรียน ตรวจสอบผลการเรียน ตารางสอบ ตารางเรียน และข้อมูลผลการศึกษา',
            'url' => 'https://reg.up.ac.th/',
            'manual_url' => 'https://does.up.ac.th/search?textg=35&text1=%E0%B8%AA%E0%B8%B3%E0%B8%AB%E0%B8%A3%E0%B8%B1%E0%B8%9A%E0%B8%99%E0%B8%B4%E0%B8%AA%E0%B8%B4%E0%B8%95&text2=%E0%B8%A3%E0%B8%B0%E0%B8%9A%E0%B8%9A%E0%B8%A3%E0%B8%B4%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%A1%E0%B8%B2%E0%B8%A3%E0%B8%A8%E0%B8%B6%E0%B8%A9%E0%B8%B2',
            'category' => ['student'],
            'badge_text' => 'REGISTRATION',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        EService::create([
            'title' => 'ระบบบริหารจัดการสหกิจศึกษา',
            'description' => 'ยื่นใบสมัครงานสหกิจศึกษา จัดการประเมินผล และดาวน์โหลดเอกสารงานสหกิจศึกษา',
            'url' => 'https://coop.up.ac.th/',
            'manual_url' => 'https://coop.up.ac.th/downloads/manual_v1.pdf',
            'category' => ['student'],
            'badge_text' => 'CO-OPERATIVE',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        EService::create([
            'title' => 'ระบบยื่นคำร้อง iService',
            'description' => 'ยื่นคำร้องคำร้องทั่วไปออนไลน์ คำร้องด้านวิชาการ และงานกิจกรรมต่างๆ สำหรับนิสิต',
            'url' => 'https://iservice.up.ac.th/',
            'manual_url' => 'https://dsa.up.ac.th/v4/eservice.php',
            'category' => ['student'],
            'badge_text' => 'I-SERVICE',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        EService::create([
            'title' => 'ระบบกองทุนเงินให้กู้ยืมเพื่อการศึกษา',
            'description' => 'ระบบบันทึกความดี ดำเนินการยื่นกู้และรายงานชั่วโมงกิจกรรม กยศ. สำหรับให้บริการกับนิสิต',
            'url' => 'https://studentservices.up.ac.th/',
            'manual_url' => 'https://dsq.up.ac.th/dist/file/Manual/%E0%B8%84%E0%B8%B9%E0%B9%88%E0%B8%A1%E0%B8%B7%E0%B8%AD%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B9%83%E0%B8%8A%E0%B9%89%E0%B8%87%E0%B8%B2%E0%B8%99%E0%B8%A3%E0%B8%B0%E0%B8%9A%E0%B8%9A%20UP%20Quality.pdf',
            'category' => ['student'],
            'badge_text' => 'STUDENT LOAN',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        EService::create([
            'title' => 'ดาวน์โหลดซอฟต์แวร์ลิขสิทธิ์',
            'description' => 'ดาวน์โหลดโปรแกรม Office 365, Windows, และโปรแกรมลิขสิทธิ์อื่นๆ ของทางมหาวิทยาลัย',
            'url' => 'https://intra.up.ac.th/account/wfrmLoginDownload.aspx',
            'manual_url' => null,
            'category' => ['student'],
            'badge_text' => 'SOFTWARE',
            'is_active' => true,
            'sort_order' => 5,
        ]);

        EService::create([
            'title' => 'จอง Co-Learning Space',
            'description' => 'จองพื้นที่สำหรับนั่งทำงานกลุ่ม ติวหนังสือ คุยงานการศึกษา ภายในคณะวิทยาศาสตร์การแพทย์',
            'url' => 'booking.rooms',
            'manual_url' => null,
            'category' => ['student', 'staff'],
            'badge_text' => 'BOOKING',
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // 2. Staff E-Services
        EService::create([
            'title' => 'ระบบจองห้องประชุมออนไลน์',
            'description' => 'ตรวจสอบคิวงาน จองห้องประชุมใหญ่ ห้องประชุมย่อย และ Co-Learning Space คณะ',
            'url' => 'booking.rooms',
            'manual_url' => null,
            'category' => ['student', 'staff'],
            'badge_text' => 'MEETING ROOM',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        EService::create([
            'title' => 'ระบบจองรถตู้ส่วนกลาง',
            'description' => 'ขออนุมัติการเดินทาง ตรวจสอบตารางการใช้รถยนต์และรถตู้ส่วนกลางคณะ',
            'url' => 'services.car-schedule',
            'manual_url' => null,
            'category' => ['staff'],
            'badge_text' => 'VEHICLE',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        EService::create([
            'title' => 'ระบบแจ้งซ่อม/Helpdesk',
            'description' => 'แจ้งซ่อมคอมพิวเตอร์ อุปกรณ์ไฟฟ้า ประปา งานอาคารและยานพาหนะคณะ',
            'url' => '#',
            'manual_url' => null,
            'category' => ['staff'],
            'badge_text' => 'HELPDESK',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        EService::create([
            'title' => 'ระบบสารสนเทศบุคลากร e-Staff',
            'description' => 'ตรวจสอบประวัติ วันลา เงินเดือน ประวัติผลงาน และข้อมูลบุคลากรทั้งหมด',
            'url' => 'https://estaff.up.ac.th',
            'manual_url' => null,
            'category' => ['staff'],
            'badge_text' => 'HR PORTAL',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        // 3. General Public E-Services
        EService::create([
            'title' => 'ระบบร้องเรียนการทุจริต',
            'description' => 'ช่องทางการแจ้งเบาะแสการทุจริต ประพฤติมิชอบ หรือร้องเรียนการบริการของหน่วยงาน',
            'url' => 'contact.corruption',
            'manual_url' => null,
            'category' => ['student', 'staff', 'general'],
            'badge_text' => 'COMPLAINT',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        EService::create([
            'title' => 'ติดต่อสอบถามข้อมูล',
            'description' => 'แบบฟอร์มส่งข้อความติดต่อคณะ แผนที่ตั้งของสำนักงาน และข้อมูลเบอร์โทรติดต่อ',
            'url' => 'contact',
            'manual_url' => null,
            'category' => ['student', 'staff', 'general'],
            'badge_text' => 'CONTACT',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        EService::create([
            'title' => 'ดาวน์โหลดเอกสารทั่วไป',
            'description' => 'ดาวน์โหลดใบคำขอทั่วไป แบบฟอร์มขอใช้สถานที่ และเอกสารสำหรับบุคคลภายนอก',
            'url' => 'downloads.index',
            'manual_url' => null,
            'category' => ['student', 'staff', 'general'],
            'badge_text' => 'DOWNLOADS',
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
