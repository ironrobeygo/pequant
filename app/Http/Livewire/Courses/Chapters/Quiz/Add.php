<?php

namespace App\Http\Livewire\Courses\Chapters\Quiz;

use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;

class Add extends Component
{
    public $course;
    public $chapter;
    public $name;

    public function mount(Course $course, Chapter $chapter){
        $this->course = $course;
        $this->chapter = $chapter;
    }

    public function render()
    {
        return view('livewire.courses.chapters.quiz.add');
    }

    public function addQuiz(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'user_id' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ];

        $this->chapter->addQuiz($data); 

        return redirect()->to('/courses/'.$this->course->id);

    }

    protected function rules(){
        return [
            'name'      => 'required'
        ];
    }
}
