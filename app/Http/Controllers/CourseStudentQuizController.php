<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseStudentQuizController extends Controller
{

    public function show(Course $course, User $student, Quiz $quiz){
        return view('course.students.quiz.show', compact('course', 'student', 'quiz'));
    }

}
