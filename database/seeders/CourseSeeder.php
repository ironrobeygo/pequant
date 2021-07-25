<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $rand = rand(2,3);
        $institutions = Institution::inRandomOrder()->limit($rand)->get()->pluck('id')->toArray();
        $instructors = User::role('instructor')->inRandomOrder()->limit(rand(1,4))->get()->pluck('id')->toArray();

        Course::factory()
            ->count(50)
            ->create()
            ->each(function($course) use ($institutions, $instructors){
                $course->syncInstitutions($institutions);
                $course->syncInstructors($instructors);
            });
    }
}
