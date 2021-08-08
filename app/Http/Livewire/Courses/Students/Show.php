<?php

namespace App\Http\Livewire\Courses\Students;

use App\Models\User;
use App\Models\Course;
use Livewire\Component;

class Show extends Component
{
    public $course;
    public $student;

    public function mount(Course $course, User $student){
        $this->course = $course;
        $this->student = $student;
    }

    public function render()
    {
        return view('livewire.courses.students.show');
    }
}
