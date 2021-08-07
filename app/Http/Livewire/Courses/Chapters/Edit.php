<?php

namespace App\Http\Livewire\Courses\Chapters;

use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;

class Edit extends Component
{
    public $course;
    public $chapter;
    public $name;
    public $content;

    public function mount(Course $course, Chapter $chapter){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->name = $this->chapter->name;
        $this->content = $this->chapter->content;
    }

    public function render()
    {
        return view('livewire.courses.chapters.edit');
    }

    public function editChapter(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'content' => $this->content,
            'updated_by' => auth()->user()->id
        ];

        $this->chapter->update($data); 

        return redirect()->to('/courses/'.$this->course->id);

    }

    protected function rules(){
        return [
            'name'      => 'required',
            'content'   => 'required',
        ];
    }
}
