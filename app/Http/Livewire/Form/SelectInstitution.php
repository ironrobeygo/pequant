<?php

namespace App\Http\Livewire\Form;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;

class SelectInstitution extends Component
{

    public $institutions; 
    public $institution_id;

    public function  mount(Institution $institution){
        $this->institutions = Institution::all();
        $this->institution_id = $institution->id;
    }

    public function selectInstitution(){

        $this->emit('updateInstitutionId', $this->institution_id);
        $this->emit('fetchInstructors', $this->institution_id);

        // if(!$this->isAlreadySelectedInstitution($this->institutions[$index])){
        //     $this->institution_ids = $this->selectedInstitutions->push($this->institutions[$index])->pluck('id');
        //     $this->emit('updateInstitutionIds', $this->institution_ids);
        //     $this->emit('fetchInstructors', $this->institution_ids);
        // }

    }

    // public function removeSelected($index){
    //     $this->selectedInstitutions->pull($index);
    //     $this->institution_ids = $this->selectedInstitutions->pluck('id');
    //     $this->emit('updateInstitutionIds', $this->institution_ids);
    //     $this->emit('fetchInstructors', $this->institution_ids);
    // }

    // public function loadSelectInstitution(){
    //     $institutions = Institution::whereIn('id', $this->institution_ids)->get()->toArray();
    //     $this->selectedInstitutions = collect($institutions);
    // }

    // protected function isAlreadySelectedInstitution($institution){

    //     $name = $institution['name'];
    //     return $this->selectedInstitutions->contains('name', $name);

    // }
    
    public function render()
    {
        return view('livewire.form.select-institution');
    }
}
