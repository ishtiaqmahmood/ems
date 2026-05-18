<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vacation;
use App\Models\LeaveType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewLeaveApplication;
use App\Notifications\LeaveStatusUpdated;

class NotificationSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_leave_application_notifies_admins()
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'Admin']);
        $viewer = User::factory()->create(['role' => 'Viewer']);
        $leaveType = LeaveType::create(['code' => 'test', 'name_en' => 'Test Leave', 'name_bn' => 'পরীক্ষামূলক ছুটি', 'max_duration' => 10, 'duration_unit' => 'day']);

        $vacation = Vacation::create([
            'user_id' => $viewer->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => 'pending',
        ]);

        Notification::assertSentTo($admin, NewLeaveApplication::class);
    }

    public function test_leave_status_update_notifies_user()
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'Admin']);
        $viewer = User::factory()->create(['role' => 'Viewer']);
        $leaveType = LeaveType::create(['code' => 'test', 'name_en' => 'Test Leave', 'name_bn' => 'পরীক্ষামূলক ছুটি', 'max_duration' => 10, 'duration_unit' => 'day']);

        $vacation = Vacation::create([
            'user_id' => $viewer->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => 'pending',
        ]);

        // Act as admin to update status
        $response = $this->actingAs($admin)->put(route('admin.leaves.update', $vacation->id), [
            'status' => 'approved',
        ]);

        $response->assertRedirect();
        Notification::assertSentTo($viewer, LeaveStatusUpdated::class);
    }

    public function test_unread_notifications_api()
    {
        $viewer = User::factory()->create(['role' => 'Viewer']);
        $leaveType = LeaveType::create(['code' => 'test', 'name_en' => 'Test Leave', 'name_bn' => 'পরীক্ষামূলক ছুটি', 'max_duration' => 10, 'duration_unit' => 'day']);

        $vacation = Vacation::create([
            'user_id' => $viewer->id,
            'leave_type_id' => $leaveType->id,
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'status' => 'pending',
        ]);

        $viewer->notify(new LeaveStatusUpdated($vacation));

        $response = $this->actingAs($viewer)->get('/api/notifications/unread');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'notifications')
            ->assertJsonPath('unreadCount', 1);
    }
}
