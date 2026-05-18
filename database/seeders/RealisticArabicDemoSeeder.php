<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AgendaItem;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Models\ExecutionTask;
use App\Models\Meeting;
use App\Models\Resolution;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RealisticArabicDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ar_SA');

        $tenantNames = ["شركة الأفق للاستثمار", "بنك التنمية المتقدم"];
        $tenantDomains = ["ufoq.test", "tanmiyah.test"];
        $roles = ['Super Admin', 'Secretary', 'Chairman', 'Board Member', 'Board Member', 'Board Member', 'Execution Manager', 'Execution Manager'];

        foreach ($tenantNames as $index => $companyName) {
            // 1. Create Tenant
            $tenant = Tenant::create([
                'name' => $companyName,
                'domain' => $tenantDomains[$index],
                'sqlite_database_path' => storage_path("app/tenants/{$tenantDomains[$index]}.sqlite"),
                'primary_color' => $index === 0 ? '#1e3a8a' : '#047857',
            ]);

            // 2. Create Users
            $users = [];
            foreach ($roles as $roleName) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => "user{$index}" . count($users) . "@" . $tenantDomains[$index],
                    'password' => Hash::make('password'),
                    'tenant_id' => $tenant->id,
                    'role' => Str::slug($roleName),
                ]);
                $users[] = $user;
            }

            // 3. Create Committees
            $committeeNames = ["لجنة المراجعة والمخاطر", "لجنة الترشيحات والمكافآت", "اللجنة التنفيذية"];
            $committees = [];
            foreach ($committeeNames as $cName) {
                $committee = Committee::create([
                    'tenant_id' => $tenant->id,
                    'name' => $cName,
                    'description' => "مسؤولة عن مهام $cName في $companyName",
                ]);
                $committees[] = $committee;

                // Assign members to committee
                foreach (array_slice($users, 2, 4) as $member) {
                    CommitteeMember::create([
                        'committee_id' => $committee->id,
                        'user_id' => $member->id,
                        'role_in_committee' => $member === $users[2] ? 'Chairman' : 'Member',
                    ]);
                }
            }

            // 4. Create Meetings
            $meetings = [];
            $meetingTitles = [
                "اجتماع مجلس الإدارة الأول لعام 2026",
                "اجتماع لجنة المراجعة الاستثنائي",
                "الاجتماع السنوي لمناقشة الميزانية",
                "اجتماع استراتيجية الربع الثالث",
                "اجتماع الطوارئ لمناقشة الاستحواذ"
            ];

            foreach ($meetingTitles as $i => $mTitle) {
                $startDate = match(true) {
                    $i < 3 => now()->subDays(rand(10, 60)), // Past
                    $i === 3 => now()->subMinutes(30), // Active
                    default => now()->addDays(rand(5, 14)) // Upcoming
                };

                $meeting = Meeting::create([
                    'tenant_id' => $tenant->id,
                    'committee_id' => $committees[array_rand($committees)]->id,
                    'title' => $mTitle,
                    'description' => "وصف مفصل لـ $mTitle",
                    'scheduled_start' => $startDate,
                    'scheduled_end' => $startDate->copy()->addHours(2),
                    'location' => 'مقر الشركة الرئيسي - قاعة الاجتماعات الكبرى',
                    'status' => $i < 3 ? 'completed' : ($i === 3 ? 'in_progress' : 'scheduled'),
                ]);
                $meetings[] = $meeting;

                // 5. Create Agenda Items
                for ($j = 1; $j <= 2; $j++) {
                    AgendaItem::create([
                        'meeting_id' => $meeting->id,
                        'title' => "البند $j: مناقشة وتقييم الأداء",
                        'description' => "تفاصيل البند $j المتعلقة بالقرارات الاستراتيجية.",
                        'allocated_minutes' => 30,
                        'order_index' => $j,
                    ]);
                }
            }

            // 6. Create Resolutions and Votes
            $resolutionTexts = [
                "يقرر المجلس اعتماد الميزانية التقديرية لعام 2026.",
                "تمت الموافقة على الاستحواذ على حصة 30% في الشركة الزميلة.",
                "الموافقة على تعيين مراجع الحسابات الخارجي.",
                "اعتماد اللائحة الجديدة لحوكمة الشركة.",
                "ترقية مدير العمليات إلى منصب الرئيس التنفيذي."
            ];

            foreach ($committees as $committee) {
                for ($k = 0; $k < 3; $k++) {
                    $resText = $faker->randomElement($resolutionTexts);
                    $resolution = Resolution::create([
                        'committee_id' => $committee->id,
                        'title' => "قرار رقم " . rand(100, 999) . " لسنة 2026",
                        'legally_binding_text' => $resText,
                        'state' => $k === 0 ? 'voting' : ($k === 1 ? 'approved' : 'rejected'),
                        'is_circular' => rand(0, 1) === 1,
                        'voting_deadline' => $k === 0 ? now()->addDays(2) : now()->subDays(5),
                    ]);

                    // Votes
                    $voters = $committee->members;
                    foreach ($voters as $voter) {
                        Vote::create([
                            'resolution_id' => $resolution->id,
                            'user_id' => $voter->user_id,
                            'type' => $k === 1 ? 'approve' : ($k === 2 ? 'reject' : $faker->randomElement(['approve', 'reject', 'abstain'])),
                        ]);
                    }
                }
            }

            // 7. Create Execution Tasks
            $taskStatuses = ['pending', 'in_progress', 'evidence_submitted', 'closed', 'escalated'];
            for ($t = 0; $t < 10; $t++) {
                ExecutionTask::create([
                    'tenant_id' => $tenant->id,
                    'resolution_id' => Resolution::where('committee_id', $committees[0]->id)->inRandomOrder()->first()?->id,
                    'assignee_id' => $users[6]->id, // Execution Manager
                    'title' => "مهمة تنفيذية: " . $faker->realText(30),
                    'description' => "يرجى تنفيذ هذا التكليف ورفع المستندات المؤيدة.",
                    'due_date' => now()->addDays(rand(-10, 20)),
                    'status' => $faker->randomElement($taskStatuses),
                ]);
            }
        }
    }
}
