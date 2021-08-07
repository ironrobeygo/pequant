<?php

namespace App\Http\Livewire\Course\Students;

use App\Models\Course;
use Livewire\Component;

class SideMenu extends Component
{
    public $course;

    public function mount(Course $course){
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.course.students.side-menu');
    }
}
