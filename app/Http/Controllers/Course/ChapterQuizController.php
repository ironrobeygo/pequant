<?php

namespace App\Http\Controllers\Course;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterQuizController extends Controller
{
    public function create(Course $course, Chapter $chapter){
        return view('admin.courses.chapters.quiz.add', compact('course', 'chapter'));
    }

    public function show(Course $course, Chapter $chapter, Quiz $quiz){
        return view('admin.courses.chapters.quiz.show', compact('course', 'chapter', 'quiz'));
    }
}
