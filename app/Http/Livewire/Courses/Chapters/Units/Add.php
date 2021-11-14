<?php

namespace App\Http\Livewire\Courses\Chapters\Units;

use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;
use Livewire\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    public $course;
    public $chapter;
    public $name;
    public $video;
    public $content;
    public $attachments = [];

    public function mount(Course $course, Chapter $chapter){
        $this->course   = $course;
        $this->chapter  = $chapter;
        $this->attachments = [
            []
        ];
    }

    public function render()
    {
        return view('livewire.courses.chapters.units.add');
    }

    public function addUnit(){

        $this->validate();

        $data = [
            'name'          => $this->name,
            'type'          => 'unit',
            'content'       => $this->content,
            'user_id'       => auth()->user()->id,
            'updated_by'    => auth()->user()->id
        ];

        $unit = $this->chapter->addUnit($data);

        if(!empty($this->attachments[0])){
            foreach ($this->attachments as $attachment) {
                $filename = pathinfo($attachment[0]->getClientOriginalName(), PATHINFO_FILENAME);
                $unit->addMedia($attachment[0]->getRealPath())
                    ->usingName($filename)
                    ->usingFileName($attachment[0]->getClientOriginalName())
                    ->toMediaCollection('images');
            }            
        }

        alert()->success('A new unit has been created.', 'Congratulations!');

        return redirect()->to('/courses/'.$this->course->id);

    }

    public function addAttachment(){
        $this->attachments[] = [];
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
    }

    protected function rules(){
        return [
            'name'      => 'required',
            'video'     => 'nullable',
            'attachments' => 'nullable',
            'content'   => 'required',
        ];
    }
}
