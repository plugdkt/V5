<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PolicyCategory;
use App\Models\PolicyDocument;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. หมวดหมู่ แผนพัฒนาบุคลากร
        $cat1 = PolicyCategory::create([
            'name' => 'แผนพัฒนาบุคลากร คณะวิทยาศาสตร์การแพทย์',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 1.1 แผนพัฒนาบุคลากร คณะวิทยาศาสตร์การแพทย์
        $groupName1 = 'แผนพัฒนาบุคลากร คณะวิทยาศาสตร์การแพทย์';
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName1,
            'sub_group_name' => null,
            'title' => 'แผนการบริหารและการพัฒนาทรัพยากรบุคคล คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา พ.ศ. 2569',
            'file_path' => 'https://www.medsci.up.ac.th/v4/medsci_doc/plan/Human_plan-69.pdf',
            'sort_order' => 1,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName1,
            'sub_group_name' => null,
            'title' => 'แผนพัฒนาบุคลากร ประจำปี 2568 - 2572',
            'file_path' => 'https://www.medsci.up.ac.th/v4/medsci_doc/plan/Human_plan-68-72.pdf',
            'sort_order' => 2,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName1,
            'sub_group_name' => null,
            'title' => 'แผนพัฒนาบุคลากร ประจำปี 2564 - 2568',
            'file_path' => 'https://www.medsci.up.ac.th/v4/medsci_doc/plan/Human_plan-64-68.pdf',
            'sort_order' => 3,
        ]);

        // 1.2 รายงานการดำเนินการตามแผนพัฒนาบุคลากร
        $groupName2 = 'รายงานการดำเนินการตามแผนพัฒนาบุคลากร';
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName2,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนพัฒนาบุคลากร ปี 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/human_plan_activity_report68.pdf',
            'sort_order' => 1,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName2,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนพัฒนาบุคลากร ปี 2567',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/human_plan_activity_report67.pdf',
            'sort_order' => 2,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName2,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินการตามนโยบายการบริหารทรัพยากรบุคคล ปี 2566 (รอบ 6 เดือน)',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/human_plan_activity_report66-6.pdf',
            'sort_order' => 3,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName2,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนพัฒนาบุคลากร ปี 2565',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/human_develop_report_65.pdf',
            'sort_order' => 4,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName2,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนพัฒนาบุคลากร ปี 2564',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/human_develop_report_64.pdf',
            'sort_order' => 5,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat1->id,
            'group_name' => $groupName2,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนพัฒนาบุคลากร ปี 2563',
            'file_path' => 'https://www.medsci.up.ac.th/V3/medsci_doc/plan/report_64/personnel_plan_report_64.pdf',
            'sort_order' => 6,
        ]);


        // 2. หมวดหมู่ บริหารจัดการความเสี่ยงและควบคุมภายใน
        $cat2 = PolicyCategory::create([
            'name' => 'บริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan)',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 2.1 แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan)
        $groupName3 = 'แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan)';
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName3,
            'sub_group_name' => null,
            'title' => 'แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan) ประจำปีงบประมาณ 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/risk_plan/RM_Plan_68.pdf',
            'sort_order' => 1,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName3,
            'sub_group_name' => null,
            'title' => 'แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan) ประจำปีงบประมาณ 2567',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/plan/66/RM-plan-66.pdf',
            'sort_order' => 2,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName3,
            'sub_group_name' => null,
            'title' => 'แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan) ประจำปีงบประมาณ 2566',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/plan/66/RM-plan-66.pdf',
            'sort_order' => 3,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName3,
            'sub_group_name' => null,
            'title' => 'แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan) ประจำปีงบประมาณ 2565',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/plan/RM-plan-65.pdf',
            'sort_order' => 4,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName3,
            'sub_group_name' => null,
            'title' => 'แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan) ประจำปีงบประมาณ 2564',
            'file_path' => 'https://www.medsci.up.ac.th/V3/medsci_doc/plan/risk_plan_64.pdf',
            'sort_order' => 5,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName3,
            'sub_group_name' => null,
            'title' => 'แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan) ประจำปีงบประมาณ 2563',
            'file_path' => 'https://www.medsci.up.ac.th/v3/medsci_doc/risk_plan/risk_plan_63.pdf',
            'sort_order' => 6,
        ]);

        // 2.2 รายงาน แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan)
        $groupName4 = 'รายงาน แผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-Plan)';
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-R6) รอบ 6 เดือน ประจำปีงบประมาณ พ.ศ. 2569',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/risk_plan/risk_acction_report_69-6.pdf',
            'sort_order' => 1,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-R12) รอบ 12 เดือน ประจำปีงบประมาณ พ.ศ. 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/risk_plan/risk_acction_report_68.pdf',
            'sort_order' => 2,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานการดำเนินการเพื่อจัดการความเสี่ยงการทุจริตและประพฤติมิชอบ ประจำปีงบประมาณ 2567',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/risk_plan/RM_Plan_report_67.pdf',
            'sort_order' => 3,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานการดำเนินการเพื่อจัดการความเสี่ยงการทุจริตและประพฤติมิชอบ ประจำปีงบประมาณ 2566',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/risk_plan/RM_report_66-6.pdf',
            'sort_order' => 4,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-R12) รอบ 6 เดือน ประจำปีงบประมาณ พ.ศ. 2565',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/risk_plan/risk_report_65-6.pdf',
            'sort_order' => 5,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนบริหารจัดการความเสี่ยงและควบคุมภายใน (RM-R12) รอบ 12 เดือน ประจำปีงบประมาณ พ.ศ. 2564',
            'file_path' => 'http://www.medsci.up.ac.th/V3/medsci_doc/risk_plan/risk_report_64.pdf',
            'sort_order' => 6,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานการควบคุมภายใน ประจำปีงบประมาณ 2563',
            'file_path' => 'https://www.medsci.up.ac.th/V3/medsci_doc/plan/report_64/report_RM_plan_63.pdf',
            'sort_order' => 7,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนบริหารจัดการความเสี่ยง (RM-R6) รอบ 12 เดือน  ประจำปีงบประมาณ 2563',
            'file_path' => 'https://www.medsci.up.ac.th/V3/medsci_doc/plan/report_64/RM-R12-63.pdf',
            'sort_order' => 8,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName4,
            'sub_group_name' => null,
            'title' => 'รายงานผลการดำเนินงานตามแผนบริหารจัดการความเสี่ยง (RM-R6) รอบ 6 เดือน  ประจำปีงบประมาณ 2563',
            'file_path' => 'https://www.medsci.up.ac.th/v3/medsci_doc/risk_plan/risk_report_63.pdf',
            'sort_order' => 9,
        ]);

        // 2.3 แผนบริหารจัดการความเสี่ยงการทุจริต และประพฤติมิชอบ
        $groupName5 = 'แผนบริหารจัดการความเสี่ยงการทุจริต และประพฤติมิชอบ';
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName5,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'แผนความเสี่ยงด้านทั่วไปและด้านป้องกันการทุจริต ประจำปีงบประมาณ 2569',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/plan/prevent_corruption_plan_69_total.pdf',
            'sort_order' => 1,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName5,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'แผนบริหารความเสี่ยง ด้านการจัดซื้อจัดจ้าง ประจำปีงบประมาณ 2569',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/plan/prevent_corruption_plan_69_procurement.pdf',
            'sort_order' => 2,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName5,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'แผนบริหารความเสี่ยง ด้านการอนุมัติ อนุญาต ประจำปีงบประมาณ 2569',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/plan/prevent_corruption_plan_69_approv.pdf',
            'sort_order' => 3,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName5,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'แผนบริหารความเสี่ยง ด้านการบริหารงานบุคคล ประจำปีงบประมาณ 2569',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/plan/prevent_corruption_plan_69_personal.pdf',
            'sort_order' => 4,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName5,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'แผนบริหารความเสี่ยง ด้านการใช้อำนาจตามกฎหมาย ประจำปีงบประมาณ 2569',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/plan/prevent_corruption_plan_69_EIT.pdf',
            'sort_order' => 5,
        ]);

        // 2.4 รายงาน แผนบริหารความเสี่ยงการทุจริต และประพฤติมิชอบ
        $groupName6 = 'รายงาน แผนบริหารความเสี่ยงการทุจริต และประพฤติมิชอบ';
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'รายงานสรุปภาพรวมความเสี่ยงด้านทั่วไปและด้านป้องกันการทุจริต ประจำปีงบประมาณ 2569 (รอบ 6 เดือน)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_69_total-6.pdf',
            'sort_order' => 1,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการจัดซื้อจัดจ้าง ประจำปีงบประมาณ 2569 (รอบ 6 เดือน)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_69_Procurement-6.pdf',
            'sort_order' => 2,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการอนุมัติ อนุญาต ประจำปีงบประมาณ 2569 (รอบ 6 เดือน)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_69_approv-6.pdf',
            'sort_order' => 3,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการบริหารงานบุคคล ประจำปีงบประมาณ 2569 (รอบ 6 เดือน)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_69_personal-6.pdf',
            'sort_order' => 4,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2569',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการใช้อำนาจตามกฎหมาย ประจำปีงบประมาณ 2569 (รอบ 6 เดือน)',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_69_EIT-6.pdf',
            'sort_order' => 5,
        ]);

        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2568',
            'title' => 'รายงานสรุปภาพรวมความเสี่ยงด้านทั่วไปและด้านป้องกันการทุจริต ประจำปีงบประมาณ 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_68_total.pdf',
            'sort_order' => 6,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2568',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการจัดซื้อจัดจ้าง ประจำปีงบประมาณ 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_68_Procurement.pdf',
            'sort_order' => 7,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2568',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการอนุมัติ อนุญาต ประจำปีงบประมาณ 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_68_approv.pdf',
            'sort_order' => 8,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2568',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการบริหารงานบุคคล ประจำปีงบประมาณ 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_68_personal.pdf',
            'sort_order' => 9,
        ]);
        PolicyDocument::create([
            'policy_category_id' => $cat2->id,
            'group_name' => $groupName6,
            'sub_group_name' => 'ประจำปีงบประมาณ 2568',
            'title' => 'รายงาน แผนบริหารความเสี่ยง ด้านการใช้อำนาจตามกฎหมาย ประจำปีงบประมาณ 2568',
            'file_path' => 'https://www.medsci.up.ac.th/V4/medsci_doc/corruption/report/prevent_corruption_report_68_EIT.pdf',
            'sort_order' => 10,
        ]);
    }
}
