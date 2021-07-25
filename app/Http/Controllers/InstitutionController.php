<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(){
        return view('admin.institutions.index');
    }

    public function create(){
        return view('admin.institutions.add');   
    }

    public function show(Institution $institution){
        return view('admin.institutions.show', compact('institution'));
    }

    public function edit(Institution $institution){
        return view('admin.institutions.edit', compact('institution'));
    }
}
