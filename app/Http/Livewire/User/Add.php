<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Add extends Component
{

    public $name;
    public $email;
    public $contact_number;
    public $institution_id;
    public $role;

    public function render()
    {
        $institutions = Institution::all();
        $roles = Role::where("name", "!=", "Student")->get();

        return view('livewire.user.add', compact('institutions', 'roles'));
    }

    public function newUser(){
        $this->validate();
        $data = [
            'name'              => $this->name,
            'email'             => $this->email,
            'contact_number'    => $this->contact_number,
            'password'          => Hash::make('!@#$%^&*'),
            'institution_id'    => $this->institution_id
        ];

        $user = User::create($data);
        $user->assignRole($this->role);

        alert()->success("A {$this->role} has been created.", 'Congratulations!');

        return redirect()->to('/users');

    }

    protected function rules(){
        return [
            'name'              => 'required',
            'email'             => 'required',
            'contact_number'    => 'required',
            'institution_id'    => 'required',
            'role'              => 'required'
        ];
    }
}
