<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Activity;
use App\Models\Institution;
use App\Models\Announcement;

class Dashboard extends Component
{

    public $announcements;
    public $institutions;
    public $courses;
    public $students;
    public $activities;
    public $progress;

    public function mount(){

        $this->institutions = Institution::get()->count();
        $this->courses = Course::get()->count();
        $this->students = User::whereHas("roles", function($q){ 
                $q->where("name", "Student"); }
            )->get()->count();

        $this->announcements = Announcement::where('status', 1)->latest()->take(5)->get();


        if(auth()->user()->hasRole('instructor')){

            $institution_id = auth()->user()->institution_id;
            $course_ids = auth()
                            ->user()
                            ->instructorCourses()
                            ->pluck('id')
                            ->values()
                            ->toArray();

            $include_ids = User::with('roles')
                ->whereHas('roles', function($query){
                    $query->whereIn("name", ['student']);
                })
                ->whereHas('studentCourses', function($query) use($course_ids){
                    $query->where('course_id', $course_ids);
                })
                ->get()
                ->pluck('id')
                ->values()
                ->toArray();

                array_push($include_ids, auth()->user()->id);

            $this->activities = Activity::whereIn('user_id', $include_ids)->latest()->take(10)->get();

        } else {
            $this->activities = Activity::latest()->take(10)->get();
        }

    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
