<?php

namespace App\Http\Livewire\User\Student;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Unit;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Progress;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public $course;
    public $title;
    public $video;
    public $content;
    public $progress;
    public $visited;
    public $questions;
    public $counter;
    public $zoomSignature;
    public $submitQuiz;
    public $answerType;

    public function mount(Course $course){
        $this->course = $course;
        $this->title = '';
        $this->video = '';
        $this->content = '';
        $this->questions = [];
        $this->progress = [];
        $this->visited = [];
        $this->counter = 1;
        $this->zoomSignature = '';
        $this->submitQuiz = [];
        $this->answerType = 'checkbox';
    }

    public function render()
    {

        $this->progress = auth()->user()
            ->progress()
            ->whereNotNull('completed_at')
            ->get()
            ->pluck('unit_id')->toArray();

        $this->visited = auth()->user()
            ->progress()
            ->get()
            ->pluck('unit_id')->toArray();

        return view('livewire.user.student.show');

    }

    public function updateContent($id, $type){

        if($type == 'unit'){
            $unit = Unit::find($id);
            $this->title = $unit->name;
            $this->video = $unit->video;
            $this->content = $unit->content;

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
            $quiz = Quiz::find($id);
            $this->title = $quiz->name;
            $this->questions = $quiz->questions->where('status', 1);
            
            if( auth()->user()->hasRole('student') ){
                $admins = User::whereHas("roles", function($q){ $q->where("name", "admin"); })->get()->pluck('id')->toArray();
                $instructor = $this->course->instructor->id;
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
        dd($this->submitQuiz);
    }

    public function hostZoomLive(){      

        $user = auth()->user();
        $firstName = $user->firstName();
        $institution = $user->institution;
        if( $user->hasRole('admin') ){
            $institution = $this->course->instructor->institution;
        } 

        $meeting_number = 84882799343;
        $password = 911412;
        $role = 0;

        $this->zoomSignature = '/zoom?user='.$user->firstName().'&api='.$institution->zoom_api.'&secret='.$institution->zoom_secret.'&meeting_number='.$meeting_number.'&password='.$password.'&role='.$role;
    }
}
