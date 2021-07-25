<?php

namespace App\Http\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class ListCategories extends Component
{
    use WithPagination;
    
    public $perPage = 5;

    public function render()
    {
        $categories = Category::simplePaginate($this->perPage);
        return view('livewire.categories.list-categories', compact('categories'));
    }

}
