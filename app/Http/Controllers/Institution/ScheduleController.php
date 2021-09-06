<?php

namespace App\Http\Controllers\Institution;

use App\Models\Institution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index(Institution $institution){
        return view('admin.institutions.schedules.index', compact('institution'));
    }

    public function create(Institution $institution){
        return view('admin.institutions.schedules.add', compact('institution')); 
    }
}
