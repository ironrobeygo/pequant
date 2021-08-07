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
    public $contact_number;
    public $institution_id;

    public function mount(User $student){

        $this->student = $student;
        $this->name = $this->student->name;
        $this->email = $this->student->email;
        $this->contact_number = $this->student->contact_number;
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
            'contact_number'    => $this->contact_number,
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
            'contact_number'    => 'nullable',
            'institution_id'    => 'required'
        ];
    }
}
