<?php

namespace App\Http\Livewire\Courses\Chapters\Quiz;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;
use App\Models\Question;

class Show extends Component
{
    public $course;
    public $chapter;
    public $quiz;

    public $listeners = ["questionUpdated" => 'render'];

    public function mount(Course $course, Chapter $chapter, Quiz $quiz){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->quiz = $quiz;
    }
    
    public function render()
    {
        return view('livewire.courses.chapters.quiz.show');
    }

    public function delete($id){

        $question = Question::find($id);
        $question->delete();
        $this->emitSelf('questionUpdated');

    }

    public function updateStatus($id){

        $question = Question::find($id);
        $question->status = !$question->status;
        $question->save();
        $this->emitSelf('questionUpdated');

    }
}
