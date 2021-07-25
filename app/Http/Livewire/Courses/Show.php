<?php

namespace App\Http\Livewire\Courses;

use Livewire\Component;

class Show extends Component
{
    public $course;

    public function mount($course){
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.courses.show', [
            'course' => $this->course
        ]);
    }
}
