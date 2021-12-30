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
    public $counter;
    public $visited;
    public $next;
    public $previous;
    public $navigation;
    public $units;
    public $currentId;
    public $event;

    public function mount(Course $course){
        $this->course = $course;
        $this->title = '';
        $this->video = '';
        $this->content = '';
        $this->counter = 1;
        $this->progress = [];
        $this->visited = [];
        $this->questions = [];
        $this->next = null;
        $this->previous = null;
        $this->currentId = 0;

        $date = date('Y-m-d');

        $this->event        = $this->course->events()->whereBetween('start', [$date.' 00:00:00', $date.' 23:59:59'])->first() !== null ? $this->course->events()->whereBetween('start', [$date.' 00:00:00', $date.' 23:59:59'])->first() : null ;

        $this->units = $course->chapters->map(function($chapter){
            return $chapter->units->map(function($unit){ 
                return $unit->only(['id']);
            })->values()->flatten();
        })->values()->flatten()->toArray();

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
            $this->currentId  = $unit->id;
            $this->questions = [];

            $data = [
                'unit_id' => $unit->id,
            ];

            $next_id = $this->findIndex($id) + 1;
            $prev_id = $this->findIndex($id) - 1;

            $this->getNext($next_id);
            $this->getPrev($prev_id);
            
        }

        if($type == 'quiz'){
            $quiz = Quiz::find($id);
            $this->title = $quiz->name;
            $this->questions = $quiz->questions->where('status', 1);
            $this->currentId  = $quiz->id;

            $next_id = $this->findIndex($id) + 1;
            $prev_id = $this->findIndex($id) - 1;

            $this->getNext($next_id);
            $this->getPrev($prev_id);
            
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
