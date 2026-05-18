<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use App\Models\Department;
use App\Models\Section;
use App\Models\Employer;
use App\Models\Event;
use App\Models\Attendance;
use App\Models\Vacation;
use App\Models\LeaveType;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'Admin',
            'password' => bcrypt('password'),
        ]);

        $viewer = User::factory()->create([
            'name' => 'Viewer User',
            'email' => 'viewer@example.com',
            'role' => 'Viewer',
            'password' => bcrypt('password'),
        ]);

        $org = Organization::create([
            'name' => 'Acme Corp',
            'email' => 'contact@acme.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        $dept = Department::create([
            'organization_id' => $org->id,
            'name' => 'Engineering',
            'description' => 'Development team',
        ]);

        $section = Section::create([
            'organization_id' => $org->id,
            'department_id' => $dept->id,
            'name' => 'Backend',
            'description' => 'API and Core logic',
        ]);

        for ($i = 0; $i < 10; $i++) {
            Employer::create([
                'organization_id' => $org->id,
                'department_id' => $dept->id,
                'section_id' => $section->id,
                'name' => 'Employee ' . ($i + 1),
                'email' => 'employee' . ($i + 1) . '@example.com',
                'phone' => '0123456789' . $i,
                'designation' => 'Software Engineer',
                'gender' => 'male',
                'status' => 'active',
                'joining_date' => now()->subMonths($i),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Event::create([
                'user_id' => $admin->id,
                'title' => 'Event ' . ($i + 1),
                'description' => 'Description for event ' . ($i + 1),
                'start_datetime' => now()->addDays($i + 1),
                'end_datetime' => now()->addDays($i + 1)->addHours(2),
                'location' => 'Meeting Room ' . ($i + 1),
                'color' => '#4f46e5',
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Attendance::create([
                'user_id' => $viewer->id,
                'date' => now()->subDays($i),
                'status' => 'Present',
                'check_in' => '09:00:00',
                'check_out' => '17:00:00',
            ]);
        }

        $lt = LeaveType::create([
            'code' => 'casual',
            'name_bn' => 'নৈমিত্তিক ছুটি',
            'name_en' => 'Casual Leave',
            'max_duration' => 15,
            'duration_unit' => 'day'
        ]);

        for ($i = 0; $i < 5; $i++) {
            Vacation::create([
                'user_id' => $viewer->id,
                'leave_type_id' => $lt->id,
                'start_date' => now()->addWeeks($i + 2),
                'end_date' => now()->addWeeks($i + 2)->addDays(3),
                'status' => 'pending',
                'reason' => 'Personal reason ' . ($i + 1),
            ]);
        }
    }
}
