<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public $user;
    public $name;
    public $email;
    public $contact_number;
    public $institution_id;
    public $role;

    public function mount(User $user){

        $this->user = $user;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->contact_number = $this->user->contact_number;
        $this->institution_id = $this->user->institution_id;
        $this->role = $this->user->getRoleNames()[0];

    }

    public function render()
    {

        $institutions = Institution::all();
        $roles = Role::all();

        return view('livewire.user.edit', compact('institutions', 'roles'));
    }

    public function editUser(){
        $this->validate();
        $data = [
            'name'              => $this->name,
            'email'             => $this->email,
            'contact_number'    => $this->contact_number,
            'institution_id'    => $this->institution_id
        ];

        $this->user->update($data);

        $this->user->syncRoles($this->role);

        alert()->success("An {$this->role} information has been updated.", 'Congratulations!');

        return redirect()->to('/users');

    }

    protected function rules(){
        return [
            'name'              => 'required',
            'email'             => 'required',
            'contact_number'    => 'nullable',
            'institution_id'    => 'required',
            'role'              => 'required'
        ];
    }

}
