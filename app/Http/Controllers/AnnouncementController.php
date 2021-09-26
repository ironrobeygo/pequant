<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(){
        return view('admin.announcements.index');
    }

    public function create(){
        return view('admin.announcements.add');   
    }

    public function edit(Announcement $announcement){
        return view('admin.announcements.edit', compact('announcement'));
    }
}
