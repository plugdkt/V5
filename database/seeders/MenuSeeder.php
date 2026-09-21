<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Header Menus
        $headerItems = [
            ['title_th' => 'หน้าหลัก', 'title_en' => 'Home', 'url' => '/', 'order' => 1],
            ['title_th' => 'เกี่ยวกับคณะ', 'title_en' => 'About', 'url' => '/about', 'order' => 2],
            ['title_th' => 'หลักสูตร', 'title_en' => 'Programs', 'url' => '/programs', 'order' => 3],
            ['title_th' => 'วิจัย', 'title_en' => 'Research', 'url' => '/research', 'order' => 4],
            ['title_th' => 'บริการ', 'title_en' => 'Services', 'url' => '/services', 'order' => 5],
            ['title_th' => 'ข่าวสาร', 'title_en' => 'News', 'url' => '/news', 'order' => 6],
            ['title_th' => 'ติดต่อเรา', 'title_en' => 'Contact', 'url' => '/contact', 'order' => 7],
        ];

        foreach ($headerItems as $item) {
            MenuItem::updateOrCreate(
                ['location' => 'header', 'url' => $item['url']],
                [
                    'title_th' => $item['title_th'],
                    'title_en' => $item['title_en'],
                    'order' => $item['order'],
                    'active' => true
                ]
            );
        }

        // 2. Footer About Menus
        $footerAbout = [
            ['title_th' => 'ประวัติความเป็นมา', 'url' => '/about', 'order' => 1],
            ['title_th' => 'โครงสร้างองค์กร', 'url' => '/about/structure', 'order' => 2],
            ['title_th' => 'ผู้บริหาร', 'url' => '/about/management', 'order' => 3],
            ['title_th' => 'บุคลากร', 'url' => '/personnel', 'order' => 4],
            ['title_th' => 'วิสัยทัศน์ / พันธกิจ', 'url' => '/about/vision', 'order' => 5],
        ];

        foreach ($footerAbout as $item) {
            MenuItem::updateOrCreate(
                ['location' => 'footer_about', 'url' => $item['url']],
                [
                    'title_th' => $item['title_th'],
                    'order' => $item['order'],
                    'active' => true
                ]
            );
        }

        // 3. Footer Programs Menus
        $footerProg = [
            ['title_th' => 'จุลชีววิทยา', 'url' => '/programs/microbiology', 'order' => 1],
            ['title_th' => 'ชีวเคมี', 'url' => '/programs/biochemistry', 'order' => 2],
            ['title_th' => 'โภชนาการฯ', 'url' => '/programs/nutrition', 'order' => 3],
        ];

        foreach ($footerProg as $item) {
            MenuItem::updateOrCreate(
                ['location' => 'footer_programs', 'url' => $item['url']],
                [
                    'title_th' => $item['title_th'],
                    'order' => $item['order'],
                    'active' => true
                ]
            );
        }

        // 4. Footer Services Menus
        $footerSrv = [
            ['title_th' => 'จองห้องประชุม', 'url' => '/booking/rooms', 'order' => 1],
            ['title_th' => 'E-Service', 'url' => '/services', 'order' => 2],
            ['title_th' => 'แบบฟอร์ม/ดาวน์โหลด', 'url' => '/downloads', 'order' => 3],
            ['title_th' => 'ประกาศจัดซื้อจัดจ้าง', 'url' => '/news?category=procurement', 'order' => 4],
            ['title_th' => 'สายตรงคณบดี', 'url' => '/contact', 'order' => 5],
        ];

        foreach ($footerSrv as $item) {
            MenuItem::updateOrCreate(
                ['location' => 'footer_services', 'url' => $item['url']],
                [
                    'title_th' => $item['title_th'],
                    'order' => $item['order'],
                    'active' => true
                ]
            );
        }
    }
}
