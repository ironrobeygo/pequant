<?php

namespace App\Http\Livewire\User\Student;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Course;
use Livewire\Component;
use App\Models\Progress;

class Show extends Component
{
    public $course;
    public $title;
    public $video;
    public $content;
    public $progress;
    public $visited;
    public $zoomSignature = '';

    public function mount(Course $course){
        $this->course = $course;
        $this->title = '';
        $this->video = '';
        $this->content = '';
        $this->progress = [];
        $this->visited = [];
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


        }

    }

    public function progressUpdate($id){
        $progress = Progress::where('student_id', auth()->user()->id)
                        ->where('unit_id', $id)
                        ->first();
        $progress->completed_at = Carbon::now();
        $progress->save();
    }

    public function hostZoomLive(){      

        $user = auth()->user();
        $meeting_number = 84882799343;
        $password = 911412;
        $role = 0;

        $this->zoomSignature = '/zoom?user='.$user->firstName().'&api='.$user->institution->zoom_api.'&secret='.$user->institution->zoom_secret.'&meeting_number='.$meeting_number.'&password='.$password.'&role='.$role;
    }
}
