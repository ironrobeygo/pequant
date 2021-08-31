<?php

namespace App\Http\Livewire\Courses;

use App\Models\Quiz;
use App\Models\Unit;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use App\Models\Progress;

class Preview extends Component
{
    public $course;
    public $title;
    public $video;
    public $content;
    public $progress;
    public $questions;
    public $counter = 1;
    public $visited;

    public function mount(Course $course){
        $this->course = $course;
        $this->title = '';
        $this->video = '';
        $this->content = '';
        $this->progress = [];
        $this->visited = [];
        $this->questions = [];
    }

    public function render()
    {
        return view('livewire.courses.preview');
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
        }

    }
}
