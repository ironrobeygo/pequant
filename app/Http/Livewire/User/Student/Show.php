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
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

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

        $this->progress = auth()->user()
            ->progress()
            ->whereNotNull('completed_at')
            ->get()
            ->pluck('unit_id')->toArray();

        $this->visited = auth()->user()
            ->progress()
            ->get()
            ->pluck('unit_id')->toArray();

        $this->answered = auth()->user()
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
            $this->currentUnit  = $unit->id;
            $this->currentQuiz  = 0;
            $this->questions    = [];
            $this->status       = '';
            $this->quizMessage  = '';

            $data = [
                'unit_id' => $unit->id,
            ];

            $exists = Progress::where('student_id', auth()->user()->id)
                        ->where('unit_id', $id)
                        ->first();

            if( $exists === null ){
                auth()->user()->addProgress($data);
            }

            
        }

        if($type == 'quiz'){
            $quiz               = Quiz::find($id);
            $this->title        = $quiz->name;
            $this->questions    = $quiz->questions->where('status', 1);
            $this->video        = '';
            $this->content      = '';
            $this->currentUnit  = 0;
            $this->currentQuiz  = $quiz->id;
            $this->submitQuiz   = [];

            if(in_array($quiz->id, $this->answered)){
                $this->status       = 'Congratulations on completing your quiz!';
                $this->quizMessage  = 'You will be notified when this quiz has been graded.';
            }
            
            if( auth()->user()->hasRole('student') ){
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
        $progress = Progress::where('student_id', auth()->user()->id)
                        ->where('unit_id', $id)
                        ->first();
        $progress->completed_at = Carbon::now();
        $progress->save();
    }

    public function submitQuiz(){

        $user = auth()->user();
        $type = 'text';
        $score = 0;
        $total = count($this->questions);
        $quiz_type = 'choices';

        if( array_key_exists('attachments', $this->submitQuiz) ){

            foreach($this->submitQuiz['attachments'] as $attachment){
                foreach($attachment as $key => $attach){
                    $filename = pathinfo($attach->getClientOriginalName(), PATHINFO_FILENAME);
                    $fileUpload = $user->addMedia($attach->getRealPath())
                        ->usingName($filename)
                        ->usingFileName($attach->getClientOriginalName())
                        ->toMediaCollection('quiz');

                    $data = [
                        'question_id'   => $key,
                        'type'          => 'file',
                        'answer'        => $fileUpload->id,
                        'point'         => 0
                    ];
                    $user->addAnswer($data);
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
                'question_id'   => $key,
                'type'          => $type,
                'answer'        => $temp,
                'point'         => $point
            ];
            $user->addAnswer($data);
        }

        $quizData = [
            'quiz_id' => $this->currentQuiz,
            'score' => $score
        ];

        $user->addScore($quizData);

        $this->status       = $score . '/'. $total;
        $this->quizMessage  = 'Congratulations on completing your quiz!';

        if( $quiz_type == 'custom' ){
            $this->status       = 'Congratulations on completing your quiz!';
            $this->quizMessage  = 'You will be notified after your quiz has been graded by your instructor.';
        }


    }

}
