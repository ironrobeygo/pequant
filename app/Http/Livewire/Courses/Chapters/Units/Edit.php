<?php

namespace App\Http\Livewire\Courses\Chapters\Units;

use App\Models\Unit;
use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads;

    public $course;
    public $chapter;
    public $unit;
    public $name;
    public $video;
    public $content;
    public $medias;
    public $attachments;

    public function mount(Course $course, Chapter $chapter, Unit $unit){
        $this->course   = $course;
        $this->chapter  = $chapter;
        $this->unit     = $unit;
        $this->name     = $this->unit->name;
        $this->video    = $this->unit->video;
        $this->content  = $this->unit->content;
        $this->medias   = $unit->getMedia('images');
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

        alert()->success('A unit has been updated successfully.', 'Congratulations!');

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

    public function removeMedia($index){
        $this->medias[$index]->delete();
        unset($this->medias[$index]);
    }

    protected function rules(){
        return [
            'name'      => 'required',
            'video'     => 'nullable',
            'content'   => 'required',
        ];
    }
}
