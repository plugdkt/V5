<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;
use App\Models\Page;

class MegamenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Delete old header menus to rebuild properly
        MenuItem::where('location', 'header')->delete();

        // 2. Main menu items
        $home = MenuItem::create(['title_th' => 'หน้าหลัก', 'url' => '/', 'location' => 'header', 'order' => 1]);
        
        $about = MenuItem::create(['title_th' => 'เกี่ยวกับคณะ', 'url' => '#', 'location' => 'header', 'order' => 2]);
        
        $programs = MenuItem::create(['title_th' => 'หลักสูตร', 'url' => '/programs', 'location' => 'header', 'order' => 3]);
        
        $services = MenuItem::create(['title_th' => 'บริการ', 'url' => '/services', 'location' => 'header', 'order' => 4]);
        
        $contact = MenuItem::create(['title_th' => 'ติดต่อเรา', 'url' => '/contact', 'location' => 'header', 'order' => 5]);

        // 3. Add Megamenu structure under $about (parent_id = $about->id)
        
        // Column 1: แนะนำคณะ
        $col1 = MenuItem::create(['title_th' => 'แนะนำคณะ', 'url' => '#', 'parent_id' => $about->id, 'location' => 'header', 'order' => 1]);
        MenuItem::create(['title_th' => 'ประวัติความเป็นมา', 'url' => '/about', 'parent_id' => $col1->id, 'location' => 'header', 'order' => 1]);
        MenuItem::create(['title_th' => 'โครงสร้างองค์กร', 'url' => '/about/structure', 'parent_id' => $col1->id, 'location' => 'header', 'order' => 2]);
        MenuItem::create(['title_th' => 'ผู้บริหาร', 'url' => '/about/management', 'parent_id' => $col1->id, 'location' => 'header', 'order' => 3]);
        MenuItem::create(['title_th' => 'บุคลากร', 'url' => '/personnel', 'parent_id' => $col1->id, 'location' => 'header', 'order' => 4]);
        MenuItem::create(['title_th' => 'หน่วยงานภายใน', 'url' => '/pages/internal-departments', 'parent_id' => $col1->id, 'location' => 'header', 'order' => 5]);
        MenuItem::create(['title_th' => 'อำนาจหน้าที่', 'url' => '/pages/duties-and-powers', 'parent_id' => $col1->id, 'location' => 'header', 'order' => 6]);

        // Create missing pages in database to prevent 404 when clicking
        Page::firstOrCreate(['slug' => 'internal-departments'], ['title' => 'หน่วยงานภายใน', 'body' => '<p>รายละเอียดหน่วยงานภายใน</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'duties-and-powers'], ['title' => 'อำนาจหน้าที่', 'body' => '<p>รายละเอียดอำนาจหน้าที่</p>', 'published' => true]);

        // Column 2: ด้านบริหารงาน
        $col2 = MenuItem::create(['title_th' => 'ด้านบริหารงาน', 'url' => '#', 'parent_id' => $about->id, 'location' => 'header', 'order' => 2]);
        MenuItem::create(['title_th' => 'แผนยุทธศาสตร์', 'url' => '/pages/strategic-plan', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 1]);
        MenuItem::create(['title_th' => 'แผนการดำเนินงาน', 'url' => '/pages/action-plan', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 2]);
        MenuItem::create(['title_th' => 'แผน / นโยบาย / มาตรการ', 'url' => '/pages/policies', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 3]);
        MenuItem::create(['title_th' => 'ประกาศแผนจัดซื้อจัดจ้าง', 'url' => '/news?category=procurement-plan', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 4]);
        MenuItem::create(['title_th' => 'รายงานผลการดำเนินงาน', 'url' => '/pages/annual-report', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 5]);
        MenuItem::create(['title_th' => 'รายงานการประชุมคณะกรรมการบริหาร', 'url' => '/pages/board-meeting-minutes', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 6]);
        MenuItem::create(['title_th' => 'ประกาศจัดซื้อจัดจ้าง', 'url' => '/news?category=procurement', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 7]);
        MenuItem::create(['title_th' => 'หลักเกณฑ์การบริหารและพัฒนาทรัพยากรบุคคล', 'url' => '/pages/hr-guidelines', 'parent_id' => $col2->id, 'location' => 'header', 'order' => 8]);

        Page::firstOrCreate(['slug' => 'strategic-plan'], ['title' => 'แผนยุทธศาสตร์', 'body' => '<p>รายละเอียดแผนยุทธศาสตร์</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'action-plan'], ['title' => 'แผนการดำเนินงาน', 'body' => '<p>รายละเอียดแผนการดำเนินงาน</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'policies'], ['title' => 'แผน / นโยบาย / มาตรการ', 'body' => '<p>รายละเอียดนโยบายและมาตรการ</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'annual-report'], ['title' => 'รายงานผลการดำเนินงาน', 'body' => '<p>รายละเอียดรายงานประจำปี</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'board-meeting-minutes'], ['title' => 'รายงานการประชุมคณะกรรมการบริหาร', 'body' => '<p>รายงานการประชุมคณะกรรมการบริหาร</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'hr-guidelines'], ['title' => 'หลักเกณฑ์การบริหารและพัฒนาทรัพยากรบุคคล', 'body' => '<p>หลักเกณฑ์การบริหารและพัฒนาทรัพยากรบุคคล</p>', 'published' => true]);

        // Column 3: ด้านวิชาการ
        $col3 = MenuItem::create(['title_th' => 'ด้านวิชาการ', 'url' => '#', 'parent_id' => $about->id, 'location' => 'header', 'order' => 3]);
        MenuItem::create(['title_th' => 'ประกันคุณภาพการศึกษาระดับคณะ', 'url' => '/pages/qa-school', 'parent_id' => $col3->id, 'location' => 'header', 'order' => 1]);
        MenuItem::create(['title_th' => 'ประกันคุณภาพการศึกษาระดับหลักสูตร', 'url' => '/pages/qa-program', 'parent_id' => $col3->id, 'location' => 'header', 'order' => 2]);
        MenuItem::create(['title_th' => 'ข้อมูลจำนวนนิสิต', 'url' => '/pages/student-statistics', 'parent_id' => $col3->id, 'location' => 'header', 'order' => 3]);

        Page::firstOrCreate(['slug' => 'qa-school'], ['title' => 'ประกันคุณภาพการศึกษาระดับคณะ', 'body' => '<p>รายละเอียดการประกันคุณภาพระดับคณะ</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'qa-program'], ['title' => 'ประกันคุณภาพการศึกษาระดับหลักสูตร', 'body' => '<p>รายละเอียดการประกันคุณภาพระดับหลักสูตร</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'student-statistics'], ['title' => 'ข้อมูลจำนวนนิสิต', 'body' => '<p>สถิติการศึกษาและจำนวนนิสิต</p>', 'published' => true]);

        // Column 4: ด้านงานวิจัย
        $col4 = MenuItem::create(['title_th' => 'ด้านงานวิจัย', 'url' => '#', 'parent_id' => $about->id, 'location' => 'header', 'order' => 4]);
        MenuItem::create(['title_th' => 'R2R สายสนับสนุน', 'url' => '/pages/r2r', 'parent_id' => $col4->id, 'location' => 'header', 'order' => 1]);
        MenuItem::create(['title_th' => 'มาตรฐานการวิจัย', 'url' => '/pages/research-standards', 'parent_id' => $col4->id, 'location' => 'header', 'order' => 2]);
        MenuItem::create(['title_th' => 'ห้องปฏิบัติการวิจัยกลาง', 'url' => '/pages/central-lab', 'parent_id' => $col4->id, 'location' => 'header', 'order' => 3]);
        MenuItem::create(['title_th' => 'ข้อมูลงานวิจัย', 'url' => '/pages/research-info', 'parent_id' => $col4->id, 'location' => 'header', 'order' => 4]);
        MenuItem::create(['title_th' => 'บทความวิชาการ', 'url' => '/pages/academic-articles', 'parent_id' => $col4->id, 'location' => 'header', 'order' => 5]);
        MenuItem::create(['title_th' => 'สถิติผลงานวิจัย', 'url' => '/pages/research-stats', 'parent_id' => $col4->id, 'location' => 'header', 'order' => 6]);

        Page::firstOrCreate(['slug' => 'r2r'], ['title' => 'R2R สายสนับสนุน', 'body' => '<p>รายละเอียดโครงการ R2R</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'research-standards'], ['title' => 'มาตรฐานการวิจัย', 'body' => '<p>มาตรฐานจริยธรรมงานวิจัย</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'central-lab'], ['title' => 'ห้องปฏิบัติการวิจัยกลาง', 'body' => '<p>รายละเอียดห้องปฏิบัติการวิจัยกลาง</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'research-info'], ['title' => 'ข้อมูลงานวิจัย', 'body' => '<p>ฐานข้อมูลและแหล่งทุนวิจัย</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'academic-articles'], ['title' => 'บทความวิชาการ', 'body' => '<p>บทความวิชาการและวารสาร</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'research-stats'], ['title' => 'สถิติผลงานวิจัย', 'body' => '<p>สถิติและผลงานวิจัยตีพิมพ์</p>', 'published' => true]);

        // Column 5: ด้านอื่นๆ
        $col5 = MenuItem::create(['title_th' => 'ด้านอื่นๆ', 'url' => '#', 'parent_id' => $about->id, 'location' => 'header', 'order' => 5]);
        MenuItem::create(['title_th' => 'กฎหมายที่เกี่ยวข้อง', 'url' => '/pages/related-laws', 'parent_id' => $col5->id, 'location' => 'header', 'order' => 1]);
        MenuItem::create(['title_th' => 'วัฒนธรรมองค์กร', 'url' => '/pages/organizational-culture', 'parent_id' => $col5->id, 'location' => 'header', 'order' => 2]);
        MenuItem::create(['title_th' => 'การดำเนินการด้านคุณธรรมและความโปร่งใส', 'url' => '/pages/ita', 'parent_id' => $col5->id, 'location' => 'header', 'order' => 3]);
        MenuItem::create(['title_th' => 'ประมวลจริยธรรม', 'url' => '/pages/code-of-ethics', 'parent_id' => $col5->id, 'location' => 'header', 'order' => 4]);
        MenuItem::create(['title_th' => 'ข่าวทั้งหมด', 'url' => '/news', 'parent_id' => $col5->id, 'location' => 'header', 'order' => 5]);

        Page::firstOrCreate(['slug' => 'related-laws'], ['title' => 'กฎหมายที่เกี่ยวข้อง', 'body' => '<p>กฎระเบียบและข้อบังคับที่เกี่ยวข้อง</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'organizational-culture'], ['title' => 'วัฒนธรรมองค์กร', 'body' => '<p>ค่านิยมและวัฒนธรรมองค์กร</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'ita'], ['title' => 'การดำเนินการด้านคุณธรรมและความโปร่งใส', 'body' => '<p>รายงานการประเมินคุณธรรมและความโปร่งใส (ITA)</p>', 'published' => true]);
        Page::firstOrCreate(['slug' => 'code-of-ethics'], ['title' => 'ประมวลจริยธรรม', 'body' => '<p>ประมวลจริยธรรมบุคลากรของคณะ</p>', 'published' => true]);
    }
}
