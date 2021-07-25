<?php

namespace App\Http\Livewire\Institution;

use Livewire\Component;
use App\Models\Institution;

class Edit extends Component
{

    public $institution;
    public $name;
    public $zoom_email;
    public $zoom_api;
    public $zoom_secret;

    public function mount(Institution $institution){
        
        $this->institution = $institution;
        $this->name = $institution->name;
        $this->zoom_email = $institution->zoom_email;
        $this->zoom_api = $institution->zoom_api;
        $this->zoom_secret = $institution->zoom_secret;

    }
    public function render()
    {
        return view('livewire.institution.edit');
    }

    public function editInstitution(){
        $this->validate();

        $data = [
            'name' => $this->name,
            'zoom_email' => $this->zoom_email,
            'zoom_api' => $this->zoom_api,
            'zoom_secret' => $this->zoom_secret
        ];

        $this->institution->update($data);

        // return $course;
        return redirect()->to('/institutions/'.$this->institution->id.'/edit');
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
