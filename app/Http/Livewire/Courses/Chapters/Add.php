<?php

namespace App\Http\Livewire\Courses\Chapters;

use App\Models\Course;
use Livewire\Component;

class Add extends Component
{

    public $course;
    public $name;
    public $content;

    public function mount(Course $course){
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.courses.chapters.add');
    }

    public function addChapter(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'content' => $this->content,
            'user_id' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ];

        $this->course->addChapter($data); 

        return redirect()->to('/courses/'.$this->course->id);

    }

    protected function rules(){
        return [
            'name'      => 'required',
            'content'   => 'nullable',
        ];
    }
}
