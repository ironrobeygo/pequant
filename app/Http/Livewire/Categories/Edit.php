<?php

namespace App\Http\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;

class Edit extends Component
{
    public $category;
    public $name;
    public $description;

    public function mount(Category $category){

        $this->category = $category;
        $this->name = $this->category->name;
        $this->description = $this->category->description;

    }

    public function render()
    {
        return view('livewire.categories.edit');
    }

    public function editCategory(){

        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];

        $this->category->update($data);

        // return $course;
        return redirect()->to('/categories/'.$this->category->id.'/edit');

    }

    protected function rules(){
        return [
            'name'          => 'required',
            'description'   => 'nullable',
        ];
    }
}
