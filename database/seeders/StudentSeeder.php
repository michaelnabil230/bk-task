<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schools = School::inRandomOrder()->take(20)->get();

        Student::factory()
            ->count(500)
            ->sequence(fn ($sequence) => ['school_id' => $schools->random(1)->first()->id])
            ->create();

        $this->command->info('Students created.');
    }
}
