<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(){
        return view('calendar.index');
    }

    public function create(){
        return view('calendar.add');
    }

    public function edit(Event $event){
        return view('calendar.edit', compact('event'));
    }
}
