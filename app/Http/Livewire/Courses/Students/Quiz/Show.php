<?php

namespace App\Http\Livewire\Courses\Students\Quiz;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Score;
use App\Models\Answer;
use App\Models\Course;
use Livewire\Component;

class Show extends Component
{
    public $course;
    public $student;
    public $quiz;
    public $questions;
    public $answers;
    public $counter;
    public $submitScore;
    public $scoreId;

    public function mount(Course $course, User $student, Quiz $quiz){
        $this->course   = $course;
        $this->student  = $student;
        $this->quiz     = $quiz;
        $this->questions = $quiz->questions()->where('status', 1)->whereIn('user_id', array(1,2,3,4))->get();
        $this->answers  = $student->getQuizAnswers($quiz->id);
        $this->counter = 1;

        foreach( $this->answers as $key => $answer ){
            $this->submitScore[$answer['answer_id']] = $answer['point'];
        }

        $this->scoreId = $this->student->getQuizScore($quiz->id)->id;

    }

    public function render()
    {
        return view('livewire.courses.students.quiz.show');
    }

    public function getAnswerCount($data){
        $type = 'checkbox';

        $count = $data->pluck('answer')->filter(function($value, $key){
            return $value == 1;
        });

        if($count->count() == 1){
            $type = 'radio';
        }

        return $type;
    }

    public function submitQuizScore(){

        $total = 0;

        foreach($this->submitScore as $key => $score){
            $answer = Answer::find($key);
            $answer->point = $score;
            $answer->save();
            $total = $total+$score;
        }

        $score = Score::find($this->scoreId);
        $score->score = $total;
        $score->completed = 0;
        $score->save();

        alert()->success('You\'ve successfully grade a quiz.', 'Congratulations!');

        return redirect()->to('/courses/'.$this->course->id.'/students/'.$this->student->id);

    }


}
