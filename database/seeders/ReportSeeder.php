<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportCategory;
use App\Models\ReportDocument;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. หมวดหมู่ รายงานผลการดำเนินงานประจำปี
        $cat1 = ReportCategory::create([
            'name' => 'รายงานผลการดำเนินงานประจำปี',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 1.1 ปี 2569
        $g69 = 'ผลการดำเนินงานตามแผนดำเนินงานประจำปี 2569';
        ReportDocument::create([
            'report_category_id' => $cat1->id,
            'group_name' => $g69,
            'title' => 'รายงานผลการดำเนินงานตามแผนปฏิบัติการประจำปี พ.ศ. 2569 (รอบ 6 เดือน ตุลาคม 68- มีนาคม 69)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/plan/report_69/Operation_report_69-6.pdf',
            'sort_order' => 1,
        ]);

        // 1.2 ปี 2568
        $g68 = 'ผลการดำเนินงานตามแผนดำเนินงานประจำปี 2568';
        ReportDocument::create([
            'report_category_id' => $cat1->id,
            'group_name' => $g68,
            'title' => 'รายงานแผนยุทธศาสตร์การพัฒนา คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา ประจำปีงบประมาณ 2568-2572 รอบ 12 เดือน (ตุลาคม 2567 - กันยายน 2568)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/plan/report_69/Plan_report_2568-2572.pdf',
            'sort_order' => 1,
        ]);
        ReportDocument::create([
            'report_category_id' => $cat1->id,
            'group_name' => $g68,
            'title' => 'รายงานแผนปฏิบัติการ คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา ประจำปีงบประมาณ 2568 รอบ 12 เดือน (ตุลาคม 2567 - กันยายน 2568)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/plan/report_69/Acction_Plan_report_2568.pdf',
            'sort_order' => 2,
        ]);
        ReportDocument::create([
            'report_category_id' => $cat1->id,
            'group_name' => $g68,
            'title' => 'ผลความก้าวหน้าในการดำเนินงานตามแผนการดำเนินงานประจำปี พ.ศ. 2568 (รอบ 6 เดือน ตุลาคม 67- มีนาคม 68)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/plan/report_68/Operation_report_68-6.pdf',
            'sort_order' => 3,
        ]);
        ReportDocument::create([
            'report_category_id' => $cat1->id,
            'group_name' => $g68,
            'title' => 'รายงานแผนยุทธศาสตร์การพัฒนา คณะวิทยาศาสตร์การแพทย์ ประจำปีงบประมาณ 2568-2572 รอบ 6 เดือน (ตุลาคม 67 - มีนาคม 68)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/plan/report_68/plan_report_68-71-6.pdf',
            'sort_order' => 4,
        ]);

        // 1.3 ปี 2567
        $g67 = 'ผลการดำเนินงานตามแผนดำเนินงานประจำปี 2567';
        ReportDocument::create([
            'report_category_id' => $cat1->id,
            'group_name' => $g67,
            'title' => 'รายงานผลการดำเนินงานตามแผนปฏิบัติการ ประจำปี 2567',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/plan/report_68/Operation_report_67.pdf',
            'sort_order' => 1,
        ]);
        ReportDocument::create([
            'report_category_id' => $cat1->id,
            'group_name' => $g67,
            'title' => 'รายงานแผนยุทธศาสตร์การพัฒนา คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา ประจำปีงบประมาณ พ.ศ. 2567 - 2571',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/plan/report_68/Plan_report_2567-2571.pdf',
            'sort_order' => 2,
        ]);


        // 2. หมวดหมู่ รายงานการจัดซื้อจัดจ้างหรือการจัดหาพัสดุ
        $cat2 = ReportCategory::create([
            'name' => 'รายงานการจัดซื้อจัดจ้างหรือการจัดหาพัสดุ',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 2.1 จัดซื้อจัดจ้าง ปี 2569
        $gp69 = 'การจัดซื้อจัดจ้างหรือการจัดหาพัสดุ ประจำปีงบประมาณ 2569';
        $months69 = [
            ['10-68', 'ตุลาคม 2568', 'xlsm'],
            ['11-68', 'พฤศจิกายน 2568', 'xlsm'],
            ['12-68', 'ธันวาคม 2568', 'xlsm'],
            ['01-69', 'มกราคม 2569', 'xlsm'],
            ['02-69', 'กุมภาพันธ์ 2569', 'xlsm'],
            ['03-69', 'มีนาคม 2569', 'xlsm'],
            ['04-69', 'เมษายน 2569', 'xlsm'],
        ];
        foreach ($months69 as $i => $m) {
            ReportDocument::create([
                'report_category_id' => $cat2->id,
                'group_name' => $gp69,
                'title' => "แบบสรุปผลการดำเนินการจัดซื้อจัดจ้างในรอบเดือน : {$m[1]}",
                'file_path' => "https://www.medsci.up.ac.th/parcel_sys/document/Procurement_report/2569/pdf/{$m[0]}.pdf",
                'file_path_excel' => "https://www.medsci.up.ac.th/parcel_sys/document/Procurement_report/2569/Excel/{$m[0]}.{$m[2]}",
                'sort_order' => $i + 1,
            ]);
        }

        // 2.2 จัดซื้อจัดจ้าง ปี 2568
        $gp68 = 'การจัดซื้อจัดจ้างหรือการจัดหาพัสดุ ประจำปีงบประมาณ 2568';
        $months68 = [
            ['10-67', 'ตุลาคม 2567', 'xlsx'],
            ['11-67', 'พฤศจิกายน 2567', 'xlsx'],
            ['12-67', 'ธันวาคม 2567', 'xlsx'],
            ['01-68', 'มกราคม 2568', 'xlsx'],
            ['02-68', 'กุมภาพันธ์ 2568', 'xlsx'],
            ['03-68', 'มีนาคม 2568', 'xlsx'],
            ['04-68', 'เมษายน 2568', 'xlsx'],
            ['05-68', 'พฤษภาคม 2568', 'xlsx'],
            ['06-68', 'มิถุนายน 2568', 'xlsx'],
            ['07-68', 'กรกฎาคม 2568', 'xlsx'],
            ['08-68', 'สิงหาคม 2568', 'xlsx'],
            ['09-68', 'กันยายน 2568', 'xlsx'],
        ];
        foreach ($months68 as $i => $m) {
            ReportDocument::create([
                'report_category_id' => $cat2->id,
                'group_name' => $gp68,
                'title' => "แบบสรุปผลการดำเนินการจัดซื้อจัดจ้างในรอบเดือน : {$m[1]}",
                'file_path' => "https://www.medsci.up.ac.th/parcel_sys/document/Procurement_report/2568/pdf/{$m[0]}.pdf",
                'file_path_excel' => "https://www.medsci.up.ac.th/parcel_sys/document/Procurement_report/2568/Excel/{$m[0]}.{$m[2]}",
                'sort_order' => $i + 1,
            ]);
        }
        // Summary 2568
        ReportDocument::create([
            'report_category_id' => $cat2->id,
            'group_name' => $gp68,
            'title' => 'แบบสรุปรายงานและปัญหาอุปสรรค ประจำปีงบประมาณ 2568',
            'file_path' => 'https://www.medsci.up.ac.th/parcel_sys/document/Procurement_report/2568/pdf/Summary-report-68.pdf',
            'file_path_excel' => 'https://www.medsci.up.ac.th/parcel_sys/document/Procurement_report/2568/Excel/Summary-report-68.xlsx',
            'sort_order' => 13,
        ]);

        // 2.3 จัดซื้อจัดจ้าง ปี 2567
        $gp67 = 'การจัดซื้อจัดจ้างหรือการจัดหาพัสดุ ประจำปีงบประมาณ 2567';
        ReportDocument::create([
            'report_category_id' => $cat2->id,
            'group_name' => $gp67,
            'title' => 'รายงานผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุประจำปี พ.ศ. 2567',
            'file_path' => 'https://www.medsci.up.ac.th/parcel_sys/document/Procurement_report/Procurement_report_67.xlsx',
            'sort_order' => 1,
        ]);


        // 3. หมวดหมู่ การเปิดโอกาสให้บุคคลภายนอกได้มีส่วนร่วมในการดำเนินงานตามภารกิจ
        $cat3 = ReportCategory::create([
            'name' => 'การเปิดโอกาสให้บุคคลภายนอกได้มีส่วนร่วมในการดำเนินงานตามภารกิจ',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 3.1 การเปิดโอกาสให้เกิดการมีส่วนร่วม
        $gpPart = 'การเปิดโอกาสให้เกิดการมีส่วนร่วม';
        ReportDocument::create([
            'report_category_id' => $cat3->id,
            'group_name' => $gpPart,
            'title' => 'รายงานผลการเปิดโอกาสให้บุคคลภายนอกได้มีส่วนร่วมในการดำเนินงานตามภารกิจ ประจำปี 2569',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/Provide_participation_69.pdf',
            'sort_order' => 1,
        ]);
        ReportDocument::create([
            'report_category_id' => $cat3->id,
            'group_name' => $gpPart,
            'title' => 'รายงานผลการเปิดโอกาสให้บุคคลภายนอกได้มีส่วนร่วมในการดำเนินงานตามภารกิจ ประจำปี 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/Provide_participation_68.pdf',
            'sort_order' => 2,
        ]);
    }
}
