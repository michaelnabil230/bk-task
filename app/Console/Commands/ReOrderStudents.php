<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Student;
use App\Notifications\StudentReorder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class ReOrderStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reorder-students';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix order students';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->reOrderStudents();
        $this->sendNotification();

        $this->info('Order students successfully');

        return 0;
    }

    private function reOrderStudents(): void
    {
        $students = Student::query()
            ->latest('order')
            ->withTrashed()
            ->get();

        foreach ($students->whereNotNull('deleted_at') as $student) {
            $lowerPriorityStudents = $students
                ->whereNull('deleted_at')
                ->where('school_id', $student->school_id)
                ->where('order', '>', $student->order);

            foreach ($lowerPriorityStudents as $lowerPriorityStudent) {
                $lowerPriorityStudent->order--;
                $lowerPriorityStudent->saveQuietly();
            }
        }
    }

    private function sendNotification(): void
    {
        Admin::chunk(200, function ($admins) {
            Notification::send($admins, new StudentReorder());
        });
    }
}
