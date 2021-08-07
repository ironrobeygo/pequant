<?php

namespace App\Http\Controllers\Course;

use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    public function create(Course $course){
        return view('admin.courses.chapters.add', compact('course'));
    }

    public function edit(Course $course, Chapter $chapter){
        return view('admin.courses.chapters.edit', compact('course', 'chapter'));
    }

    public function show(Course $course, Chapter $chapter){
        return view('admin.courses.chapters.show', compact('course', 'chapter'));
    } 
}
