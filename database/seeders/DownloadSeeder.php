<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FileCategory;

class DownloadSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing categories safely
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        FileCategory::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // Create default categories
        FileCategory::create([
            'name' => 'แบบฟอร์มสำหรับนิสิต',
            'icon' => '🎓',
            'order' => 1
        ]);

        FileCategory::create([
            'name' => 'แบบฟอร์มสำหรับบุคลากร',
            'icon' => '👤',
            'order' => 2
        ]);

        FileCategory::create([
            'name' => 'ประกาศและระเบียบข้อบังคับ',
            'icon' => '📢',
            'order' => 3
        ]);
    }
}
