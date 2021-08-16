<?php

namespace App\Http\Controllers\Course;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoursePreviewController extends Controller
{
    public function index(Course $course){
        return view('admin.courses.preview', compact('course'));
    }
}
