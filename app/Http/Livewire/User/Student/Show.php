<?php

namespace App\Http\Livewire\User\Student;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Unit;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Progress;
use App\Models\Question;
use App\Events\QuizOpened;
use App\Events\UnitOpened;
use App\Events\QuizSubmitted;
use App\Events\UnitCompleted;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public $student;
    public $currentUnit;
    public $currentQuiz;
    public $course;
    public $title;
    public $video;
    public $content;
    public $progress;
    public $visited;
    public $answered;
    public $questions;
    public $counter;
    public $status;
    public $quizMessage;
    public $submitQuiz;
    public $answerType;

    public function mount(Course $course){
        $this->course       = $course;
        $this->title        = '';
        $this->video        = '';
        $this->content      = '';
        $this->questions    = [];
        $this->progress     = [];
        $this->visited      = [];
        $this->answered     = [];
        $this->counter      = 1;
        $this->status       = '';
        $this->quizMessage  = '';
        $this->submitQuiz   = [];
        $this->answerType   = 'checkbox';
        $this->currentQuiz  = 0;
        $this->currentUnit  = 0;
        $this->student      = auth()->user();

        $this->progress = $this->student
            ->progress()
            ->whereNotNull('completed_at')
            ->get()
            ->pluck('unit_id')->toArray();

        $this->visited = $this->student
            ->progress()
            ->get()
            ->pluck('unit_id')->toArray();

        $this->answered = $this->student
            ->scores()
            ->get()
            ->pluck('quiz_id')->toArray();
    }

    public function render()
    {

        return view('livewire.user.student.show');

    }

    public function updateContent($id, $type){

        if($type == 'unit'){
            $unit               = Unit::find($id);
            $this->title        = $unit->name;
            $this->video        = $unit->video ? $unit->video : '';
            $this->content      = $unit->content;
            $this->currentUnit  = $unit;
            $this->currentQuiz  = 0;
            $this->questions    = [];
            $this->status       = '';
            $this->quizMessage  = '';

            event(new UnitOpened(auth()->user(), $this->currentUnit));

            $data = [
                'unit_id' => $unit->id,
            ];

            $exists = Progress::where('student_id', $this->student->id)
                        ->where('unit_id', $id)
                        ->first();

            if( $exists === null ){
                $this->student->addProgress($data);
            }

            
        }

        if($type == 'quiz'){
            $quiz               = Quiz::find($id);
            $this->title        = $quiz->name;
            $this->questions    = $quiz->questions->where('status', 1);
            $this->video        = '';
            $this->content      = '';
            $this->currentUnit  = 0;
            $this->currentQuiz  = $quiz;
            $this->submitQuiz   = [];

            event(new QuizOpened(auth()->user(), $this->currentQuiz));

            if(in_array($quiz->id, $this->answered)){

                $quizScore = $this->student->getQuizScore($quiz->id);

                $this->status       = $quizScore->score .'/'.$quiz->getQuizTotal();
                $this->quizMessage  = 'Congratulations on completing your quiz!';
            }
            
            if( $this->student->hasRole('student') ){
                $admins         = User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get()->pluck('id')->toArray();
                $instructor     = $this->course->instructor->id;
                array_push($admins, $instructor);
                $this->questions = $quiz->questions->where('status', 1)->whereIn('user_id', $admins);
            }

        }

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

    public function progressUpdate($id){

        $unit = Unit::find($id);

        $progress = Progress::where('student_id', $this->student->id)
                        ->where('unit_id', $id)
                        ->first();
        $progress->completed_at = Carbon::now();
        $progress->save();

        event(new UnitCompleted($this->student, $unit));
    }

    public function submitQuiz(){

        $type = 'text';
        $score = 0;
        $total = count($this->questions);
        $quiz_type = 'choices';

        if( array_key_exists('attachments', $this->submitQuiz) ){

            foreach($this->submitQuiz['attachments'] as $attachment){
                foreach($attachment as $key => $attach){
                    $filename = pathinfo($attach->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileUpload = $this->student->addMedia($attach->getRealPath())
                        ->usingName($filename)
                        ->usingFileName($attach->getClientOriginalName())
                        ->toMediaCollection('quiz');

                    $data = [
                        'quiz_id'       => $this->currentQuiz->id,
                        'question_id'   => $key,
                        'type'          => 'file',
                        'answer'        => $fileUpload->id,
                        'point'         => 0
                    ];
                    $this->student->addAnswer($data);
                }
            }

            $quiz_type = 'custom';

            unset($this->submitQuiz['attachments']);
        }

        $temps = array_values($this->submitQuiz);

        foreach($temps[0] as $key => $temp){

            $point = 0;

            if(is_array($temp)){
                $type = 'options';

                if(count($temp) > 1){
                    $temp = array_keys($temp);
                }

                $questionAnswer = Question::find($key)
                    ->options
                    ->filter(function($value, $key){
                        return $value->answer == 1;
                    })
                    ->pluck('id')
                    ->toArray();

                sort($temp);
                sort($questionAnswer);

                if( $temp == $questionAnswer ){
                    $point = 1;
                    $score++;
                }

                $temp = json_encode($temp);
            } else {
                $quiz_type = 'custom';
            }

            $data = [
                'quiz_id'       => $this->currentQuiz->id,
                'question_id'   => $key,
                'type'          => $type,
                'answer'        => $temp,
                'point'         => $point
            ];

            $this->student->addAnswer($data);
        }

        $quizData = [
            'quiz_id' => $this->currentQuiz->id,
            'score' => $score
        ];

        if( $quiz_type == 'custom' ){
            $quizData['completed'] = 1;
        }

        event(new QuizSubmitted($this->student, $this->currentQuiz));

        $this->student->addScore($quizData);

        $this->status       = $score . '/'. $total;
        $this->quizMessage  = 'Congratulations on completing your quiz!';

        if( $quiz_type == 'custom' ){
            $this->status       = 'Congratulations on completing your quiz!';
            $this->quizMessage  = 'You will be notified after your quiz has been graded by your instructor.';
        }


    }

}
