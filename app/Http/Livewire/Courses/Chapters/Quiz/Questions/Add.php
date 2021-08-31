<?php

namespace App\Http\Livewire\Courses\Chapters\Quiz\Questions;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Option;
use App\Models\Chapter;
use Livewire\Component;
use App\Models\Question;
use Livewire\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;

    public $course;
    public $chapter;
    public $quiz;
    public $type_id;
    public $question;
    public $weight;
    public $showOptionsForm = false;
    public $options = [];
    public $attachments = [];

    public function mount(Course $course, Chapter $chapter, Quiz $quiz){
        $this->course = $course;
        $this->chapter = $chapter;
        $this->type_id = 2; //default
        $this->quiz = $quiz;
        $this->options[] = ['value' => '', 'answer' => false];
        $this->attachments = [
            []
        ];
    }

    public function multipleChoice($value){
        if( $value == 1){
            $this->showOptionsForm = true;
        } else {
            $this->showOptionsForm = false;
            $this->options = [
                ['value' => '', 'answer' => false]
            ];
        }

        $this->dispatchBrowserEvent('contentChanged');
    }

    public function addQuestion(){

        $this->validate();

        $data = [
            'question'  => $this->question,
            'type_id'   => $this->type_id,
            'user_id'   => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'status'    => auth()->user()->hasRole('admin') ? Question::ACTIVE : Question::PENDING,
            'weight'    => $this->weight == '' ? 0 : $this->weight
        ];

        $question = $this->quiz->addQuestion($data);

        if($this->type_id == 1){

            $options = array();

            foreach($this->options as $option){

                $opt = new Option;
                $opt->value = $option['value'];
                $opt->answer = $option['answer'];
                $opt->save();

                $options[] = $opt->id;

            }

            $question->syncOptions($options);
        }

        if(!empty($this->attachments[0])){
            foreach ($this->attachments as $attachment) {
                $filename = pathinfo($attachment[0]->getClientOriginalName(), PATHINFO_FILENAME);
                $question->addMedia($attachment[0]->getRealPath())
                    ->usingName($filename)
                    ->usingFileName($attachment[0]->getClientOriginalName())
                    ->toMediaCollection('images');
            }
        }

        return redirect()->to('/courses/'.$this->course->id.'/chapters/'.$this->chapter->id.'/quiz/'.$this->quiz->id);

    }

    public function addOption(){
        $this->options[] = [
            'value' => '',
            'answer' => false
        ];
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function addAttachment(){
        $this->attachments[] = [];
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
    }

    public function render()
    {
        return view('livewire.courses.chapters.quiz.questions.add');
    }

    protected function rules(){
        return [
            'question'  => 'required'
        ];
    }
}
