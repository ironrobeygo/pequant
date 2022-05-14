<?php

namespace App\Http\Livewire\User\Student;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Unit;
use App\Models\User;
use App\Models\Score;
use App\Models\Course;
use Livewire\Component;
use App\Models\Progress;
use App\Models\Question;
use App\Events\QuizOpened;
use App\Events\UnitOpened;
use App\Events\QuizSubmitted;
use App\Events\UnitCompleted;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InstructorQuizNotification;

class Show extends Component
{
    use WithFileUploads;

    public $next;
    public $units;
    public $title;
    public $video;
    public $event;
    public $course;
    public $status;
    public $content;    
    public $student;
    public $counter;
    public $visited;
    public $answered;
    public $progress;
    public $previous;
    public $complete;
    public $questions;
    public $currentId;
    public $submitQuiz;
    public $answerType;
    public $showRetake;
    public $currentUnit;
    public $currentQuiz;
    public $quizMessage;
    public $disabledQuiz;

    protected $listeners = ['updateContent'];

    public function mount(Course $course){
        $this->course       = $course;
        $this->title        = '';
        $this->content      = '';
        $this->status       = '';
        $this->quizMessage  = '';
        $this->submitQuiz   = [];
        $this->questions    = [];
        $this->progress     = [];
        $this->visited      = [];
        $this->answered     = [];
        $this->disabledQuiz = [];
        $this->currentQuiz  = 0;
        $this->currentUnit  = 0;
        $this->currentId    = 0;
        $this->counter      = 1;
        $this->answerType   = 'checkbox';
        $this->student      = auth()->user();
        $this->showRetake   = false;
        $this->complete     = false;
        
        $date = date('Y-m-d');

        $this->event        = $this->course->events()->whereBetween('start', [$date.' 00:00:00', $date.' 23:59:59'])->first() !== null ? $this->course->events()->whereBetween('start', [$date.' 00:00:00', $date.' 23:59:59'])->first() : null ;

        $this->units = $course->chapters->map(function($chapter){
            return $chapter->units->map(function($unit){ 
                return $unit->only(['id']);
            })->values()->flatten();
        })->values()->flatten()->toArray();

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
            ->where('retake', 0)
            ->get()
            ->pluck('quiz_id')->toArray();
    }

    public function render(){
        return view('livewire.user.student.show');
    }

    public function updateContent($id, $type){

        if($type == 'unit'){

            if($this->currentId != 0){
                $this->goComplete($this->currentId);
            }

            $unit               = Unit::find($id);
            $this->title        = $unit->name;
            $this->content      = $unit->content;
            $this->currentUnit  = $unit;
            $this->currentQuiz  = 0;
            $this->currentId    = $unit->id;
            $this->questions    = [];
            $this->status       = '';
            $this->quizMessage  = '';
            $this->disabledQuiz = [];

            $next_id = $this->findIndex($id) + 1;
            $prev_id = $this->findIndex($id) - 1;

            $this->getNext($next_id);
            $this->getPrev($prev_id);

            event(new UnitOpened(auth()->user(), $this->currentUnit));

            $data = [
                'unit_id' => $unit->id
            ];

            $exists = Progress::where('student_id', $this->student->id)
                        ->where('unit_id', $id)
                        ->first();

            array_push($this->visited, $this->currentId);

            if( $exists === null ){
                $this->student->addProgress($data);
            } 
            
        }

        if($type == 'quiz'){

            if($this->currentId != 0){
                $this->goComplete($this->currentId);
            }

            $quiz               = Quiz::find($id);
            $this->title        = $quiz->name;
            $this->questions    = $quiz->questions->where('status', 1);
            $this->video        = '';
            $this->content      = '';
            $this->currentUnit  = 0;
            $this->currentQuiz  = $quiz;
            $this->currentId    = $quiz->id;
            $this->submitQuiz   = [];
            $this->nextID       = $quiz->id;
            $this->disabledQuiz = $quiz->chapter->units->where('order', '<', $quiz->order)->pluck('id')->toArray();

            $next_id = $this->findIndex($id) + 1;
            $prev_id = $this->findIndex($id) - 1;

            $this->getNext($next_id);
            $this->getPrev($prev_id);

            event(new QuizOpened(auth()->user(), $this->currentQuiz));

            if(in_array($quiz->id, $this->answered)){

                $quizScore          = $this->student->getQuizScore($quiz->id);
                $quizCompleted      = $this->student->scores()->where('quiz_id', $quiz->id)->orderBy('updated_at', 'desc')->first()->completed;
                $retakeCount        = $this->student->scores()->where('quiz_id', $quiz->id)->get()->count();

                $this->status       = $quizScore->score .'/'.$quiz->getQuizTotal();
                $this->quizMessage  = 'Congratulations on completing your quiz!';

                $this->showRetake = ( $quizCompleted == 1 && $retakeCount < 3 ? true : false );

            } else {

                $this->status = '';
                $this->quizMessage = '';

                if( $this->student->hasRole('student') ){
                    $admins         = User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get()->pluck('id')->toArray();
                    $instructor     = $this->course->instructor->id;
                    array_push($admins, $instructor);
                    $this->questions = $quiz->questions->where('status', 1)->whereIn('user_id', $admins);
                }
            }

        }

        $this->dispatchBrowserEvent('adjustHeight');

    }

    public function goNext($current, $id, $type){
        $this->goComplete($current);
        $this->updateContent($id, $type);
    }

    public function goComplete($current){
        $currentObject = Progress::where('student_id', $this->student->id)
                    ->where('unit_id', $current)
                    ->first();

        if($currentObject !== null){
            $currentObject->completed_at = Carbon::now();
            $currentObject->save();

            array_push($this->progress, $current);
            array_push($this->visited, $current);
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

        if( count($temps) > 0 ){
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

                    $question = Question::find($key);

                    if( isset($question->answerKey) ){
                        $type = 'identification';

                        if( $temp == $question->answerKey->answer ){
                            $point = 1;
                            $score++;
                        }
                    } else {
                       $quiz_type = 'custom'; 
                    }

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
        }

        $quizData = [
            'quiz_id' => $this->currentQuiz->id,
            'score' => $score
        ];

        if( $quiz_type == 'custom' ){
            $quizData['completed'] = 1;
        }

        $userData = [
            'course' => $this->course->name,
            'quiz' => $this->currentQuiz->name,
            'user'  => auth()->user()->name, 
            'instructor' => $this->course->instructor->name
        ];

        event(new QuizSubmitted($this->student, $this->currentQuiz));
        // Notification::send($this->course->instructor, new InstructorQuizNotification($userData));

        $this->student->addScore($quizData);

        $this->status       = $score . '/'. $total;
        $this->quizMessage  = 'Congratulations on completing your quiz!';

        if( $quiz_type == 'custom' ){

            $quizCompleted      = $this->student->scores()->where('quiz_id', $this->currentQuiz->id)->orderBy('updated_at', 'desc')->first()->completed;
            $retakeCount        = $this->student->scores()->where('quiz_id', $this->currentQuiz->id)->get()->count();

            $this->status       = 'Congratulations on completing your quiz!';
            $this->quizMessage  = 'You will be notified after your quiz has been graded by your instructor.';

            $this->showRetake = ( $quizCompleted == 1 && $retakeCount < 3 ? true : false );
        }
    }

    public function retakeQuiz($quiz_id){

        $submission = Score::where('user_id', $this->student->id)->where('quiz_id', $quiz_id)->orderBy('updated_at', 'desc')->first();

        $submission->retake = 1;
        $submission->save();

        $quiz               = Quiz::find($quiz_id);
        $this->title        = $quiz->name;
        $this->questions    = $quiz->questions->where('status', 1);
        $this->video        = '';
        $this->content      = '';
        $this->currentUnit  = 0;
        $this->currentQuiz  = $quiz;
        $this->submitQuiz   = [];
        $this->status       = '';
        $this->quizMessage  = '';

        if( $this->student->hasRole('student') ){
            $admins         = User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get()->pluck('id')->toArray();
            $instructor     = $this->course->instructor->id;
            array_push($admins, $instructor);
            $this->questions = $quiz->questions->where('status', 1)->whereIn('user_id', $admins);
        }
    }

    public function findIndex($id){
        return array_search($id, $this->units);
    }

    public function getNext($next_id){

        $unitCount = count($this->units);
        if( $next_id < $unitCount ){
            $unit_id = $this->units[$next_id];
            $unit = Unit::where('id', $unit_id)->first();

            $this->next = $unit->only('id', 'type');
        } else {
            $this->next = null;
            $this->complete = true;
        }
    }

    public function getPrev($prev_id){

        if( $prev_id >= 0 ){
            $unit_id = $this->units[$prev_id];
            $unit = Unit::where('id', $unit_id)->first();

            $this->previous = $unit->only('id', 'type');
        } else {
            $this->previous = null;
        }
    }


}
