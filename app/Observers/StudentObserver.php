<?php

namespace App\Observers;

use App\Models\Student;

class StudentObserver
{
    /**
     * Handle the Student "creating" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function creating(Student $student)
    {
        if (is_null($student->order)) {
            $student->order = Student::query()
                ->where('school_id', $student->school_id)
                ->max('order') + 1;

            return;
        }

        $lowerPriorityStudents = Student::query()
            ->where('school_id', $student->school_id)
            ->where('order', '>=', $student->order)
            ->get();

        foreach ($lowerPriorityStudents as $lowerPriorityStudent) {
            $lowerPriorityStudent->order++;
            $lowerPriorityStudent->saveQuietly();
        }
    }

    /**
     * Handle the Student "updating" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function updating(Student $student)
    {
        if ($student->isClean('order')) {
            return;
        }

        if (is_null($student->order)) {
            $student->order = Student::query()
                ->where('school_id', $student->school_id)
                ->max('order');
        }

        if ($student->getOriginal('order') > $student->order) {
            $orderRange = [
                $student->order, $student->getOriginal('order'),
            ];
        } else {
            $orderRange = [
                $student->getOriginal('order'), $student->order,
            ];
        }

        $lowerPriorityStudents = Student::query()
            ->where('school_id', $student->school_id)
            ->where('id', '!=', $student->id)
            ->whereBetween('order', $orderRange)
            ->get();

        foreach ($lowerPriorityStudents as $lowerPriorityStudent) {
            if ($student->getOriginal('order') < $student->order) {
                $lowerPriorityStudent->order--;
            } else {
                $lowerPriorityStudent->order++;
            }
            $lowerPriorityStudent->saveQuietly();
        }
    }

    /**
     * Handle the Student "deleted" event.
     *
     * @param  \App\Models\Student  $student
     * @return void
     */
    public function deleted(Student $student)
    {
        // $lowerPriorityStudents = Student::query()
        //     ->where('school_id', $student->school_id)
        //     ->where('order', '>', $student->order)
        //     ->get();

        // foreach ($lowerPriorityStudents as $lowerPriorityStudent) {
        //     $lowerPriorityStudent->order--;
        //     $lowerPriorityStudent->saveQuietly();
        // }
    }
}
