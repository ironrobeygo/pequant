<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        return view('admin.categories');
    }

    public function create(Category $category){
        return view('admin.categories.edit', compact('category'));
    }

    public function edit(Category $category){
        return view('admin.categories.edit', compact('category'));
    }
}
