<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Institution;

class Dashboard extends Component
{
    public function render()
    {

        $institutions = Institution::get()->count();
        $courses = Course::get()->count();
        $students = User::whereHas("roles", function($q){ 
                $q->where("name", "Student"); }
            )->get()->count();

        return view('livewire.dashboard', compact('institutions', 'courses', 'students'));
    }
}
