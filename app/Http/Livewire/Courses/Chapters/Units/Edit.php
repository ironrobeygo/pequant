<?php

namespace App\Http\Livewire\Courses\Chapters\Units;

use App\Models\Unit;
use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;

class Edit extends Component
{
    public $course;
    public $chapter;
    public $unit;
    public $name;
    public $video;
    public $content;

    public function mount(Course $course, Chapter $chapter, Unit $unit){
        $this->course   = $course;
        $this->chapter  = $chapter;
        $this->unit     = $unit;
        $this->name     = $this->unit->name;
        $this->video    = $this->unit->video;
        $this->content  = $this->unit->content;
    }

    public function render()
    {
        return view('livewire.courses.chapters.units.edit');
    }

    public function editUnit(){

        $this->validate();

        $data = [
            'name'          => $this->name,
            'video'         => $this->video,
            'content'       => $this->content,
            'updated_by'    => auth()->user()->id
        ];

        $this->unit->update($data); 

        return redirect()->to('/courses/'.$this->course->id);

    }

    protected function rules(){
        return [
            'name'      => 'required',
            'video'     => 'nullable',
            'content'   => 'required',
        ];
    }
}
