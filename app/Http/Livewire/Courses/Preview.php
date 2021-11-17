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
    public $next;
    public $previous;

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
            $this->questions = [];

            $data = [
                'unit_id' => $unit->id,
            ];

            $next = $unit->chapter->units->filter(function($value, $key) use ($unit){
               return $value->order > $unit->order; 
            });

            $previous = $unit->chapter->units->filter(function($value, $key) use ($unit){
               return $value->order < $unit->order; 
            });

            $this->next = (count($next) == 0 ? null : $next->first()->only('id', 'type')  );
            $this->previous = (count($previous) == 0 ? null : $previous->first()->only('id', 'type') );
            
        }

        if($type == 'quiz'){
            $quiz = Quiz::find($id);
            $this->title = $quiz->name;
            $this->questions = $quiz->questions->where('status', 1);

            $next = $quiz->chapter->units->filter(function($value, $key) use ($quiz){
               return $value->order > $quiz->order; 
            });

            $previous = $quiz->chapter->units->filter(function($value, $key) use ($quiz){
               return $value->order < $quiz->order; 
            });

            $this->next = (count($next) == 0 ? null : $next->first()->only('id', 'type')  );
            $this->previous = (count($previous) == 0 ? null : $previous->first()->only('id', 'type') );
            
        }

    }
}
