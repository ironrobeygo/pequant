<?php

namespace App\Http\Livewire\Institution;

use Livewire\Component;
use App\Models\Institution;

class Add extends Component
{

    public $name;
    public $zoom_email;
    public $zoom_api;
    public $zoom_secret;

    public function render()
    {
        return view('livewire.institution.add');
    }

    public function addInstitution(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'zoom_email' => $this->zoom_email,
            'zoom_api' => $this->zoom_api,
            'zoom_secret' => $this->zoom_secret
        ];

        $institution = Institution::create($data); 

        return redirect()->to('/institutions/'.$institution->id);

    }

    protected function rules(){
        return [
            'name'          => 'required',
            'zoom_email'    => 'nullable',
            'zoom_api'      => 'nullable',
            'zoom_secret'   => 'nullable'
        ];
    }
}
