<?php

namespace App\Http\Livewire\Courses\Chapters\Quiz;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;

class Edit extends Component
{
    public $course;
    public $chapter;
    public $quiz;
    public $name;

    public function mount(Course $course, Chapter $chapter, Quiz $quiz){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->quiz = $quiz;
        $this->name = $this->quiz->name;
    }

    public function render()
    {
        return view('livewire.courses.chapters.quiz.edit');
    }

    public function editQuiz(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'updated_by' => auth()->user()->id
        ];

        $this->quiz->update($data); 

        return redirect()->to('/courses/'.$this->course->id);

    }

    protected function rules(){
        return [
            'name'      => 'required'
        ];
    }
}
