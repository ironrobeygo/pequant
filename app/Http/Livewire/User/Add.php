<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;
use App\Notifications\UserCreated;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class Add extends Component
{

    public $name;
    public $email;
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

        $password = Str::random(16);

        $data = [
            'name'              => $this->name,
            'email'             => $this->email,
            'password'          => Hash::make($password),
            'institution_id'    => $this->institution_id
        ];

        $user = User::create($data);
        $user->assignRole($this->role);

        $data['password'] = $password;

        Notification::send($user, new UserCreated($data));

        alert()->success("A {$this->role} has been created.", 'Congratulations!');

        return redirect()->to('/users');

    }

    protected function rules(){
        return [
            'name'              => 'required',
            'email'             => 'required',
            'institution_id'    => 'required',
            'role'              => 'required|not_in:0'
        ];
    }
}
