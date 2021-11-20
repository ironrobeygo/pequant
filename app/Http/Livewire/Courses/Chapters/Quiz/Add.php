<?php

namespace App\Http\Livewire\Courses\Chapters\Quiz;

use App\Models\Course;
use App\Models\Chapter;
use Livewire\Component;
use Carbon\Carbon;

class Add extends Component
{
    public $course;
    public $chapter;
    public $name;
    public $expiration;
    public $attachments = [];

    public function mount(Course $course, Chapter $chapter){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->attachments = [
            []
        ];
    }

    public function render()
    {
        return view('livewire.courses.chapters.quiz.add');
    }

    public function addQuiz(){

        $this->validate();

        $expiration = $this->expiration != '' ? Carbon::parse($this->expiration)->format('Y-m-d') : null;

        $data = [
            'name' => $this->name,
            'type'  => 'quiz',
            'content' => 'empty',
            'expires_at' => $expiration,
            'user_id' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ];

        $quiz = $this->chapter->addQuiz($data); 

        // if(!empty($this->attachments[0])){
        //     foreach ($this->attachments as $attachment) {
        //         $filename = pathinfo($attachment[0]->getClientOriginalName(), PATHINFO_FILENAME);
        //         $quiz->addMedia($attachment[0]->getRealPath())
        //             ->usingName($filename)
        //             ->usingFileName($attachment[0]->getClientOriginalName())
        //             ->toMediaCollection('images');
        //     }            
        // }

        alert()->success('A new quiz has been created.', 'Congratulations!');

        return redirect()->to('/courses/'.$this->course->id);

    }

    // public function addAttachment(){
    //     $this->attachments[] = [];
    // }

    // public function removeAttachment($index)
    // {
    //     unset($this->attachments[$index]);
    // }

    protected function rules(){
        return [
            'name'      => 'required'
        ];
    }
}
