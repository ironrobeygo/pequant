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

        $zoomUser = base64_encode(auth()->user()->firstName());
        $api_key = '_yIB8zqKSHeAVFVrgRLvLw';
        $api_sercet = 'JqvpmLmgXgbKokKRjN8S57HqRBHu7mcZTt6p';
        $meeting_number = 73416191884;
        $password = 'gL8xBW';
        $role = 1;

        $this->zoomSignature = '/zoom?name='.$zoomUser.'&mn='.$meeting_number.'&pwd='.$password.'&role='.$role.'&lang=en-US&signature='.$this->signature($api_key, $api_sercet, $meeting_number, $password, $role).'&china=0&apiKey='.$api_key;
    }

    protected function signature($api_key, $api_sercet, $meeting_number, $password, $role){
        $time = time() * 1000; //time in milliseconds (or close enough)
        
        $data = base64_encode($api_key . $meeting_number . $time . $role);
        
        $hash = hash_hmac('sha256', $data, $api_sercet, true);
        
        $_sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
        
        //return signature, url safe base64 encoded
        return rtrim(strtr(base64_encode($_sig), '+/', '-_'), '=');
    }
}
