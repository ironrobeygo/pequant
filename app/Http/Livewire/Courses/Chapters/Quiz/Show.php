<?php

namespace App\Http\Livewire\Courses\Chapters\Quiz;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;

class Show extends Component
{
    public $course;
    public $chapter;
    public $quiz;

    public function mount(Course $course, Chapter $chapter, Quiz $quiz){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->quiz = $quiz;
    }
    
    public function render()
    {
        return view('livewire.courses.chapters.quiz.show');
    }
}
