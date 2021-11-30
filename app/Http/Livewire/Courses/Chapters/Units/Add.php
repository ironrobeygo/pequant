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
    public $attachments;

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
            'type'          => 'unit',
            'content'       => $this->content,
            'user_id'       => auth()->user()->id,
            'updated_by'    => auth()->user()->id
        ];

        $unit = $this->chapter->addUnit($data);

        alert()->success('A new unit has been created.', 'Congratulations!');

        return redirect()->to('/courses/'.$this->course->id);

    }

    public function updatedAttachments(){
        $filename = pathinfo($this->attachments->getClientOriginalName(), PATHINFO_FILENAME);
        $media = auth()->user()->addMedia($this->attachments->getRealPath())
            ->usingName($filename)
            ->usingFileName($this->attachments->getClientOriginalName())
            ->toMediaCollection('files');

        $this->dispatchBrowserEvent('resetFileUploader', ['uploadedUrl' => $media->getFullUrl(), 'filename' => $filename]);
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
