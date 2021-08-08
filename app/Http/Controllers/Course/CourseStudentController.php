<?php

namespace App\Http\Controllers\Course;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseStudentController extends Controller
{
    public function index(Course $course){
        return view('course.students.index', compact('course'));
    }

    public function show(Course $course, User $student){
        return view('course.students.show', compact('course', 'student'));
    }
}
