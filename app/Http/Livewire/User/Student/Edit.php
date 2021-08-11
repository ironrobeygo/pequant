<?php

namespace App\Http\Livewire\User\Student;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;

class Edit extends Component
{

    public $student;
    public $name;
    public $email;
    public $section;
    public $institution_id;

    public function mount(User $student){

        $this->student = $student;
        $this->name = $this->student->name;
        $this->email = $this->student->email;
        $this->section = $this->student->section;
        $this->institution_id = $this->student->institution_id;

    }

    public function render()
    {
        $institutions = Institution::all();

        return view('livewire.user.student.edit', compact('institutions'));
    }

    public function editStudent(){
        
        $this->validate();
        $data = [
            'name'              => $this->name,
            'email'             => $this->email,
            'section'           => $this->section,
            'institution_id'    => $this->institution_id
        ];

        $this->student->update($data);

        alert()->success('A student info has been updated.', 'Congratulations!');

        return redirect()->to('/students');

    }

    protected function rules(){
        return [
            'name'              => 'required',
            'email'             => 'required',
            'section'           => 'required',
            'institution_id'    => 'required'
        ];
    }
}
