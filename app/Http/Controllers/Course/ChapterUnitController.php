<?php

namespace App\Http\Controllers\Course;

use App\Models\Unit;
use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterUnitController extends Controller
{
    public function index(Course $course, Chapter $chapter){
        return view('admin.courses.chapters.units.index');
    }

    public function create(Course $course, Chapter $chapter){
        return view('admin.courses.chapters.units.add', compact('course', 'chapter'));
    }

    public function edit(Course $course, Chapter $chapter, Unit $unit){
        return view('admin.courses.chapters.units.edit', compact('course', 'chapter', 'unit'));
    }
}
