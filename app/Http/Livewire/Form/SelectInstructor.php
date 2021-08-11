<?php

namespace App\Http\Livewire\Form;

use App\Models\User;
use Livewire\Component;

class SelectInstructor extends Component
{
    public $instructors = [];
    public $instructor_id;

    protected $listeners = [
        'fetchInstructors'
    ];

    public function mount(){
        // $this->selectedInstructors = collect();

        // if(!is_null($ids)){
        //     $this->instructor_ids = $ids;
        //     $this->loadSelectInstructor();
        //     $this->fetchInstructors($institution_ids);
        // }
    }

    public function selectinstructor(){

        $this->emit('updateInstructor', $this->instructor_id);

    //     if(!$this->isAlreadySelectedInstructor($this->instructors[$index])){
    //         $this->instructor_ids = $this->selectedInstructors->push($this->instructors[$index])->pluck('id');
    //         $this->emit('updateInstructors', $this->instructor_ids);
    //     }

    }

    // public function removeSelected($index){
    //     $this->selectedInstructors->pull($index);
    //     $this->instructor_ids = $this->selectedInstructors->pluck('id');
    //     $this->emit('updateInstructors', $this->instructor_ids);
    // }

    // protected function isAlreadySelectedInstructor($instructor){
    //     $name = $instructor['name'];
    //     return $this->selectedInstructors->contains('name', $name);
    // }

    // public function loadSelectInstructor(){
    //     $instructors = User::whereIn('id', $this->instructor_ids)->role('instructor')->get()->toArray();
    //     $this->selectedInstructors = collect($instructors);
    // }

    public function fetchInstructors($institution_ids){
        $this->instructors = User::where('institution_id', $institution_ids)->role('instructor')->get();
    }

    public function render()
    {
        return view('livewire.form.select-instructor');
    }
}
