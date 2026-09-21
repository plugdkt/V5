<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\NewsCategory;
use App\Models\News;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\Department;
use App\Models\Position;
use App\Models\Personnel;
use App\Models\PersonnelEducation;
use App\Models\PersonnelPublication;
use App\Models\MeetingRoom;
use App\Models\RoomBooking;
use App\Models\ServiceType;
use App\Models\ServiceStat;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MigrateLegacyData extends Command
{
    protected $signature = 'medsci:migrate-legacy';
    protected $description = 'Migrate legacy data from msc_news, hr_db, room_booking, and service_report_msc';

    public function handle()
    {
        $this->info('Starting legacy data migration...');

        // Disable foreign key checks during migration
        Schema::disableForeignKeyConstraints();

        $this->migrateNews();
        $this->migrateHR();
        $this->migrateBooking();
        $this->migrateStats();

        Schema::enableForeignKeyConstraints();

        $this->info('Legacy data migration completed successfully!');
        return 0;
    }

    private function migrateNews()
    {
        $this->comment('Migrating News Categories, Articles, and Events...');

        // 1. News Categories
        try {
            $legacyCats = DB::connection('legacy_news')->table('categories')->get();
            foreach ($legacyCats as $lc) {
                NewsCategory::updateOrCreate(
                    ['slug' => $lc->key_name],
                    [
                        'name_th' => $lc->name_th,
                        'name_en' => $lc->name_en ?? Str::title($lc->key_name),
                        'color' => $lc->color ?? '#1B6CA8',
                        'order' => $lc->id
                    ]
                );
            }
            $this->info('  - News Categories migrated: ' . count($legacyCats));
        } catch (\Exception $e) {
            $this->error('  - News Categories migration failed: ' . $e->getMessage());
        }

        // 2. News Articles
        try {
            $legacyNews = DB::connection('legacy_news')->table('news')->get();
            $count = 0;
            foreach ($legacyNews as $ln) {
                // Find category
                $cat = NewsCategory::where('slug', $ln->category)->first();
                if (!$cat) {
                    $cat = NewsCategory::where('slug', 'general')->first();
                }

                // Check if already exists by slug
                $slug = Str::slug($ln->title);
                if (empty($slug)) {
                    $slug = 'news-' . $ln->id;
                }
                
                // Ensure slug unique
                $originalSlug = $slug;
                $i = 1;
                while (News::where('slug', $slug)->where('id', '!=', $ln->id)->exists()) {
                    $slug = $originalSlug . '-' . $i++;
                }

                News::updateOrCreate(
                    ['id' => $ln->id],
                    [
                        'category_id' => $cat->id,
                        'title_th' => $ln->title,
                        'title_en' => $ln->title_en ?? null,
                        'slug' => $slug,
                        'excerpt' => $ln->summary ?? Str::words(strip_tags($ln->content), 30),
                        'body' => $ln->content ?? '',
                        'cover_image' => $ln->image_url ?? null,
                        'status' => 'published',
                        'published_at' => $ln->published_at ? Carbon::parse($ln->published_at) : Carbon::parse($ln->created_at),
                        'view_count' => $ln->views ?? 0,
                        'created_at' => $ln->created_at,
                        'updated_at' => $ln->updated_at
                    ]
                );
                $count++;
            }
            $this->info("  - News Articles migrated: $count");
        } catch (\Exception $e) {
            $this->error('  - News Articles migration failed: ' . $e->getMessage());
        }

        // 3. Events
        try {
            $legacyEvents = DB::connection('legacy_news')->table('events')->get();
            $count = 0;
            
            // Ensure event category exists
            $eventCat = EventCategory::firstOrCreate(['name' => 'กิจกรรมคณะ'], ['color' => '#C9A84C']);

            foreach ($legacyEvents as $le) {
                // Determine dates
                $startDate = Carbon::parse($le->event_date);
                $endDate = Carbon::parse($le->event_date);
                if ($le->time_range) {
                    // Try parsing time
                    // e.g. "09:00 - 12:00"
                    preg_match('/(\d{2}:\d{2})\s*-\s*(\d{2}:\d{2})/', $le->time_range, $matches);
                    if (count($matches) === 3) {
                        $startParts = explode(':', $matches[1]);
                        $endParts = explode(':', $matches[2]);
                        $startDate->setTime($startParts[0], $startParts[1]);
                        $endDate->setTime($endParts[0], $endParts[1]);
                    }
                }

                Event::updateOrCreate(
                    ['id' => $le->id],
                    [
                        'category_id' => $eventCat->id,
                        'title' => $le->title,
                        'description' => $le->title_en ?? '',
                        'location' => $le->location ?? '',
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'all_day' => $le->time_range ? false : true,
                        'created_at' => $le->created_at,
                        'updated_at' => $le->updated_at
                    ]
                );
                $count++;
            }
            $this->info("  - Events migrated: $count");
        } catch (\Exception $e) {
            $this->error('  - Events migration failed: ' . $e->getMessage());
        }
    }

    private function migrateHR()
    {
        $this->comment('Migrating Departments, Positions, and Personnel Profiles...');

        // 1. Departments (Divisions)
        try {
            $legacyDivs = DB::connection('legacy_hr')->table('division')->get();
            foreach ($legacyDivs as $ld) {
                Department::updateOrCreate(
                    ['id' => $ld->id_div],
                    [
                        'name_th' => $ld->name_div,
                        'name_en' => $this->translateDivision($ld->name_div),
                        'order' => $ld->id_div
                    ]
                );
            }
            $this->info('  - Departments migrated: ' . count($legacyDivs));
        } catch (\Exception $e) {
            $this->error('  - Departments migration failed: ' . $e->getMessage());
        }

        // 2. Positions
        try {
            $legacyPos = DB::connection('legacy_hr')->table('position')->get();
            foreach ($legacyPos as $lp) {
                Position::updateOrCreate(
                    ['id' => $lp->id_pos],
                    [
                        'name_th' => $lp->name_pos,
                        'name_en' => null,
                        'level' => null
                    ]
                );
            }
            $this->info('  - Positions migrated: ' . count($legacyPos));
        } catch (\Exception $e) {
            $this->error('  - Positions migration failed: ' . $e->getMessage());
        }

        // 3. Personnel Profiles (User table in hr_db)
        try {
            $legacyUsers = DB::connection('legacy_hr')->table('user')->get();
            $count = 0;
            foreach ($legacyUsers as $lu) {
                // Split Thai name into prefix, first, last
                $parsedName = $this->parseThaiName($lu->name_user);
                
                // Split English name into prefix, first, last
                $parsedNameEn = $this->parseEnglishName($lu->name_user_en);

                // Create/Update User Account first if they have email
                $userId = null;
                if ($lu->email && filter_var($lu->email, FILTER_VALIDATE_EMAIL)) {
                    $user = User::updateOrCreate(
                        ['email' => $lu->email],
                        [
                            'name' => trim($parsedName['first'] . ' ' . $parsedName['last']),
                            'role' => 'viewer',
                            'active' => true,
                        ]
                    );
                    $userId = $user->id;
                }

                // Get photo name
                $photo = DB::connection('legacy_hr')->table('img_user')->where('id_user', $lu->id_user)->value('name_img');

                Personnel::updateOrCreate(
                    ['id' => $lu->id_user],
                    [
                        'user_id' => $userId,
                        'employee_code' => null,
                        'prefix' => $parsedName['prefix'],
                        'firstname_th' => $parsedName['first'],
                        'lastname_th' => $parsedName['last'],
                        'firstname_en' => $parsedNameEn['first'],
                        'lastname_en' => $parsedNameEn['last'],
                        'position_id' => $lu->id_pos > 0 ? $lu->id_pos : null,
                        'department_id' => $lu->id_div > 0 ? $lu->id_div : null,
                        'academic_position' => $this->getAcademicPositionName($lu->id_acad_pos),
                        'photo' => $photo ? 'assets/images/personnel/' . $photo : null,
                        'email' => $lu->email,
                        'phone' => $lu->phone,
                        'order' => $lu->line_staff ?? 0,
                        'status' => true
                    ]
                );
                $count++;
            }
            $this->info("  - Personnel Profiles migrated: $count");
        } catch (\Exception $e) {
            $this->error('  - Personnel Profiles migration failed: ' . $e->getMessage());
        }

        // 4. Educations
        try {
            $legacyEdus = DB::connection('legacy_hr')->table('education')->get();
            $count = 0;
            foreach ($legacyEdus as $le) {
                PersonnelEducation::updateOrCreate(
                    ['id' => $le->id_edu],
                    [
                        'personnel_id' => $le->id_user,
                        'degree' => $le->degree_edu ?? 'ปริญญา',
                        'field' => $le->symbol_edu ?? '',
                        'institution' => $le->univer_edu ?? '',
                        'year' => $le->year_edu ?? null
                    ]
                );
                $count++;
            }
            $this->info("  - Personnel Educations migrated: $count");
        } catch (\Exception $e) {
            $this->error('  - Personnel Educations migration failed: ' . $e->getMessage());
        }

        // 5. Publications
        try {
            $legacyPubs = DB::connection('legacy_hr')->table('publication')->get();
            $count = 0;
            foreach ($legacyPubs as $lp) {
                PersonnelPublication::updateOrCreate(
                    ['id' => $lp->id_pub],
                    [
                        'personnel_id' => $lp->id_user,
                        'title' => $lp->name_pub ?? '',
                        'journal' => $lp->site_pub ?? '',
                        'year' => $lp->year_pub ?? null,
                        'doi' => null,
                        'type' => $this->getPubTypeName($lp->id_type_pub)
                    ]
                );
                $count++;
            }
            $this->info("  - Personnel Publications migrated: $count");
        } catch (\Exception $e) {
            $this->error('  - Personnel Publications migration failed: ' . $e->getMessage());
        }
    }

    private function migrateBooking()
    {
        $this->comment('Migrating Meeting Rooms and Bookings...');

        // 1. Meeting Rooms
        try {
            $legacyRooms = DB::connection('legacy_booking')->table('rooms')->get();
            foreach ($legacyRooms as $lr) {
                MeetingRoom::updateOrCreate(
                    ['id' => $lr->id],
                    [
                        'name' => $lr->name,
                        'capacity' => $lr->capacity,
                        'location' => $lr->code, // Code is used as location in old system
                        'description' => $lr->description,
                        'image' => $lr->image ? 'assets/images/rooms/' . $lr->image : null,
                        'amenities' => ['wifi'], // default
                        'active' => $lr->status === 'active'
                    ]
                );
            }
            $this->info('  - Meeting Rooms migrated: ' . count($legacyRooms));
        } catch (\Exception $e) {
            $this->error('  - Meeting Rooms migration failed: ' . $e->getMessage());
        }

        // 2. Room Bookings
        try {
            $legacyBookings = DB::connection('legacy_booking')->table('bookings')->get();
            $count = 0;
            
            // Get a default system admin user id to assign bookings if user doesn't exist
            $defaultUser = User::first();
            $defaultUserId = $defaultUser ? $defaultUser->id : 1;

            foreach ($legacyBookings as $lb) {
                // Ensure room exists
                if (!MeetingRoom::where('id', $lb->room_id)->exists()) {
                    continue;
                }

                // Check if user exists, otherwise default
                $userId = $defaultUserId;
                // If user is set, we try to find it or create a placeholder
                if ($lb->user_id) {
                    $userId = $lb->user_id;
                    if (!User::where('id', $userId)->exists()) {
                        // Create placeholder user
                        $user = User::create([
                            'id' => $userId,
                            'name' => $lb->guest_name ?? 'Legacy User',
                            'email' => 'legacy_user_' . $userId . '@medsci.up.ac.th',
                            'role' => 'viewer',
                            'active' => false
                        ]);
                        $userId = $user->id;
                    }
                }

                // Map status
                $status = 'pending';
                if ($lb->status === 'approved') $status = 'approved';
                elseif ($lb->status === 'rejected') $status = 'rejected';
                elseif ($lb->status === 'cancelled') $status = 'cancelled';
                elseif ($lb->status === 'completed') $status = 'approved';

                RoomBooking::updateOrCreate(
                    ['id' => $lb->id],
                    [
                        'room_id' => $lb->room_id,
                        'user_id' => $userId,
                        'title' => $lb->title,
                        'purpose' => $lb->description ?? $lb->title,
                        'attendees' => $lb->attendee_count ?? 10,
                        'start_datetime' => Carbon::parse($lb->start_time),
                        'end_datetime' => Carbon::parse($lb->end_time),
                        'status' => $status,
                        'approved_by' => $lb->approved_by ?: null,
                        'approved_at' => $lb->approved_at ? Carbon::parse($lb->approved_at) : null,
                        'note' => $lb->rejection_reason ?? null,
                        'created_at' => $lb->created_at,
                        'updated_at' => $lb->updated_at
                    ]
                );
                $count++;
            }
            $this->info("  - Room Bookings migrated: $count");
        } catch (\Exception $e) {
            $this->error('  - Room Bookings migration failed: ' . $e->getMessage());
        }
    }

    private function migrateStats()
    {
        $this->comment('Migrating Service Stats...');

        try {
            $legacyLogs = DB::connection('legacy_stats')->table('service_logs')->get();
            $count = 0;

            foreach ($legacyLogs as $ll) {
                // Get service details
                $legacyService = DB::connection('legacy_stats')->table('services')->where('id', $ll->service_id)->first();
                if (!$legacyService) {
                    continue;
                }

                // Get category from department
                $legacyDeptName = DB::connection('legacy_stats')->table('departments')->where('id', $legacyService->department_id)->value('name');

                // Create service type if not exists
                $srvType = ServiceType::firstOrCreate(
                    ['name' => $legacyService->service_name],
                    [
                        'unit' => 'ราย',
                        'description' => $legacyService->service_name,
                        'category' => $legacyDeptName ?? 'ทั่วไป',
                        'active' => $legacyService->status === 'Active'
                    ]
                );

                // Parse date into year/month
                $date = Carbon::parse($ll->service_date);
                $year = $date->year;
                $month = $date->month;

                // Value is quantity
                $val = $ll->quantity ?? 1;

                // Group by year, month, type
                $existing = ServiceStat::where('service_type_id', $srvType->id)
                    ->where('period_year', $year)
                    ->where('period_month', $month)
                    ->first();

                if ($existing) {
                    $existing->value += $val;
                    $existing->save();
                } else {
                    ServiceStat::create([
                        'service_type_id' => $srvType->id,
                        'period_year' => $year,
                        'period_month' => $month,
                        'value' => $val,
                        'note' => 'Migrated from legacy log ID: ' . $ll->id
                    ]);
                }
                $count++;
            }
            $this->info("  - Service Stats records processed: $count");
        } catch (\Exception $e) {
            $this->error('  - Service Stats migration failed: ' . $e->getMessage());
        }
    }

    // Helper functions
    private function translateDivision($divName)
    {
        $map = [
            'สำนักงานเลขานุการ' => 'Secretary Office',
            'สาขาวิชาจุลชีววิทยาและปรสิตวิทยา' => 'Department of Microbiology and Parasitology',
            'สาขาวิชาชีวเคมี' => 'Department of Biochemistry',
            'สาขาวิชาโภชนาการและการกำหนดอาหาร' => 'Department of Nutrition and Dietetics',
            'สาขาวิชาสรีรวิทยา' => 'Department of Physiology',
            'สาขาวิชากายวิภาคศาสตร์' => 'Department of Anatomy',
        ];
        return $map[$divName] ?? $divName;
    }

    private function getAcademicPositionName($id)
    {
        $map = [
            1 => 'ผู้ช่วยศาสตราจารย์',
            2 => 'รองศาสตราจารย์',
            3 => 'ศาสตราจารย์',
            4 => 'อาจารย์',
        ];
        return $map[$id] ?? null;
    }

    private function getPubTypeName($id)
    {
        $map = [
            1 => 'journal',
            2 => 'conference',
            3 => 'book',
        ];
        return $map[$id] ?? 'journal';
    }

    private function parseThaiName($fullName)
    {
        $fullName = trim($fullName);
        // Normalize multiple spaces
        $fullName = preg_replace('/\s+/', ' ', $fullName);

        $prefixes = ['นาย', 'นางสาว', 'นาง', 'ดร.', 'ผศ.ดร.', 'รศ.ดร.', 'ศ.ดร.', 'ผศ.', 'รศ.', 'ศ.', 'อาจารย์', 'อ.ดร.', 'อ.'];
        $prefix = '';
        foreach ($prefixes as $p) {
            if (str_starts_with($fullName, $p)) {
                $prefix = $p;
                $fullName = trim(substr($fullName, strlen($p)));
                break;
            }
        }

        $parts = explode(' ', $fullName);
        $first = $parts[0] ?? '';
        $last = $parts[1] ?? '';

        return [
            'prefix' => $prefix ?: null,
            'first' => $first,
            'last' => $last
        ];
    }

    private function parseEnglishName($fullName)
    {
        $fullName = trim($fullName);
        $fullName = preg_replace('/\s+/', ' ', $fullName);

        $prefixes = ['Mr.', 'Mrs.', 'Ms.', 'Dr.', 'Asst. Prof. Dr.', 'Assoc. Prof. Dr.', 'Prof. Dr.', 'Asst. Prof.', 'Assoc. Prof.', 'Prof.'];
        $prefix = '';
        foreach ($prefixes as $p) {
            if (str_starts_with(strtolower($fullName), strtolower($p))) {
                $prefix = $p;
                $fullName = trim(substr($fullName, strlen($p)));
                break;
            }
        }

        $parts = explode(' ', $fullName);
        $first = $parts[0] ?? '';
        $last = $parts[1] ?? '';

        return [
            'prefix' => $prefix ?: null,
            'first' => $first,
            'last' => $last
        ];
    }
}
