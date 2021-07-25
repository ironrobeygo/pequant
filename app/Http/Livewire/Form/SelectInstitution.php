<?php

namespace App\Http\Livewire\Form;

use App\Models\User;
use Livewire\Component;
use App\Models\Institution;

class SelectInstitution extends Component
{

    public $institutions; 
    public $institution_ids;

    public $selectedInstitutions= null;

    public function  mount( $ids=null ){
        $this->institutions = Institution::all()->toArray();
        $this->selectedInstitutions = collect();
        $this->institution_ids = collect();

        if(!is_null($ids)){
            $this->institution_ids = $ids;
            $this->loadSelectInstitution();
        }
    }

    public function selectInstitution($index){

        if(!$this->isAlreadySelectedInstitution($this->institutions[$index])){
            $this->institution_ids = $this->selectedInstitutions->push($this->institutions[$index])->pluck('id');
            $this->emit('updateInstitutionIds', $this->institution_ids);
            $this->emit('fetchInstructors', $this->institution_ids);
        }

    }

    public function removeSelected($index){
        $this->selectedInstitutions->pull($index);
        $this->institution_ids = $this->selectedInstitutions->pluck('id');
        $this->emit('updateInstitutionIds', $this->institution_ids);
        $this->emit('fetchInstructors', $this->institution_ids);
    }


    public function loadSelectInstitution(){
        $institutions = Institution::whereIn('id', $this->institution_ids)->get()->toArray();
        $this->selectedInstitutions = collect($institutions);
    }

    protected function isAlreadySelectedInstitution($institution){

        $name = $institution['name'];
        return $this->selectedInstitutions->contains('name', $name);

    }
    
    public function render()
    {
        return view('livewire.form.select-institution');
    }
}
