<?php

namespace App\Http\Livewire\Courses\Chapters\Units;

use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;

class Add extends Component
{
    public $course;
    public $chapter;
    public $name;
    public $video;
    public $content;

    public function mount(Course $course, Chapter $chapter){
        $this->course   = $course;
        $this->chapter  = $chapter;
    }

    public function render()
    {
        return view('livewire.courses.chapters.units.add');
    }

    public function addUnit(){

        $this->validate();

        $data = [
            'name'          => $this->name,
            'video'         => $this->video,
            'content'       => $this->content,
            'user_id'       => auth()->user()->id,
            'updated_by'    => auth()->user()->id
        ];

        $this->chapter->addUnit($data); 

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
