<?php

namespace Tests\Notifications;

use Tests\TestCase;
use App\Models\Admin;
use App\Notifications\StudentReorder;
use Illuminate\Support\Facades\Notification;

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
