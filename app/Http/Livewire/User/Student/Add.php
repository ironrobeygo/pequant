<?php

namespace App\Http\Livewire\User\Student;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Notifications\StudentCreated;
use Illuminate\Support\Facades\Notification;

class Add extends Component
{
    public $name;
    public $email;
    public $section;
    public $institution_id;
    public $role;
    
    public function render()
    {
        $institutions = Institution::all();

        return view('livewire.user.student.add', compact('institutions'));
    }

    public function newStudent(){
        
        $this->validate();

        $password = Str::random(16);

        $data = [
            'name'              => $this->name,
            'email'             => $this->email,
            'section'           => $this->section,
            'password'          => Hash::make($password),
            'institution_id'    => $this->institution_id
        ];

        $user = User::create($data);
        $user->assignRole('student');

        $data['password'] = $password;

        Notification::send($user, new StudentCreated($data));

        alert()->success('A student has been added.', 'Congratulations!');

        return redirect()->to('/students');

    }

    protected function rules(){
        return [
            'name'              => 'required',
            'email'             => 'required|unique:users',
            'section'           => 'required',
            'institution_id'    => 'required',
        ];
    }
}
