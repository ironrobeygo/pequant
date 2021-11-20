<?php

namespace App\Http\Livewire\Courses\Chapters\Quiz;

use Carbon\Carbon;
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
    public $expiration;

    public function mount(Course $course, Chapter $chapter, Quiz $quiz){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->quiz = $quiz;
        $this->expiration = $this->quiz->expires_at;
        $this->name = $this->quiz->name;
    }

    public function render()
    {
        return view('livewire.courses.chapters.quiz.edit');
    }

    public function editQuiz(){

        $this->validate();

        $expiration = $this->expiration != '' ? Carbon::parse($this->expiration)->format('Y-m-d') : null;

        $data = [
            'name' => $this->name,
            'type'  => 'quiz',
            'content' => 'empty',
            'expires_at' => $expiration,
            'user_id' => auth()->user()->id,
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
