<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index(){     
        return view('admin.users.students.index');
    }

    public function create(){
        return view('admin.users.students.add');
    }

    public function show(){
        return view('admin.users.students.show');
    }

    public function edit(User $student){
        return view('admin.users.students.edit', compact('student'));
    }

    public function batch(){
        return view('admin.users.students.batch');
    }
}