<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GradebookController extends Controller
{
    public function index(){
        return view('users.students.gradebook.index');
    }
}
