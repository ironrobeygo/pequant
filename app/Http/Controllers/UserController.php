<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('admin.users.index');
    }

    public function create(){
        return view('admin.users.add');
    }

    public function edit(User $user){
        return view('admin.users.edit', compact('user'));
    }

    public function show(User $user){
        echo '1';
    }

    public function batch(){
        return view('admin.users.batch');
    }
}
