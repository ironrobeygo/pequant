<?php

namespace App\Http\Livewire\Courses;

use App\Models\Quiz;
use App\Models\Unit;
use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;

class Show extends Component
{
    public $count;
    public $course;
    public $zoomSignature = '';

    protected $listeners = ['deleted' => 'render', 'updated' => 'render', 'reOrderUnit'];

    public function mount(Course $course){
        $this->course = $course;
    }

    public function render()
    {

        $this->count = $this->course->students()
            ->when(auth()->user()->hasRole('instructor'), function($query){
                return $query->where('institution_id', auth()->user()->institution_id);
            })
            ->count();

        return view('livewire.courses.show');
    }

    public function deleteChapter(Chapter $chapter){

        foreach($chapter->units as $unit){
            $unit->delete();
        }
        foreach($chapter->quizzes as $quiz){
            $quiz->delete();
        }
        
        $chapter->delete();

        $this->emitSelf('deleted');
    }

    public function deleteUnit(Unit $unit){
        $unit->delete();
        $this->emitSelf('deleted');
    }

    public function deleteQuiz(Quiz $quiz){
        
        foreach($quiz->questions as $question){
            $question->delete();
        }
        $quiz->delete();
        
        $this->emitSelf('deleted');
    }

    public function reOrderUnit($data){
        $unit = Unit::find($data['unitId']);
        $unit->order = $data['order'];
        $unit->chapter_id = $data['chapterId'];
        $unit->save();

        $this->emitSelf('updated');
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
        $role = 1;

        $this->zoomSignature = '/zoom?user='.$user->firstName().'&api='.$institution->zoom_api.'&secret='.$institution->zoom_secret.'&meeting_number='.$meeting_number.'&password='.$password.'&role='.$role;

    }
}
