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
    public $questions; 

    public $listeners = ["questionUpdated" => 'render', 'reOrderQuestion'];

    public function mount(Course $course, Chapter $chapter, Quiz $quiz){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->quiz = $quiz;
    }
    
    public function render()
    {
        $this->questions = $this->quiz->questions()->orderBy('order', 'asc')->get();
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


    public function reOrderQuestion($data){
        $question = Question::find($data['id']);
        $question->order = $data['order'];
        $question->save();

        $this->emitSelf('questionUpdated');
    }
}
