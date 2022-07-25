<?php

namespace Tests\Notifications;

use App\Models\Admin;
use App\Notifications\StudentReorder;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReOrderStudentNotificationTest extends TestCase
{
    public function test_the_notification_reorder_students_command()
    {
        Notification::fake();

        $admin = Admin::factory()->create();

        $admin->notify(new StudentReorder());

        Notification::assertSentTo($admin, StudentReorder::class);
    }
}
