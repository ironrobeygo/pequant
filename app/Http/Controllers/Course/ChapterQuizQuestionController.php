<?php

namespace App\Http\Controllers\Course;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterQuizQuestionController extends Controller
{
    public function create(Course $course, Chapter $chapter, Quiz $quiz){
        return view('admin.courses.chapters.quiz.questions.add', compact('course', 'chapter', 'quiz'));
    }

    public function edit(Course $course, Chapter $chapter, Quiz $quiz, Question $question){
        return view('admin.courses.chapters.quiz.questions.edit', compact('course', 'chapter', 'quiz', 'question'));
    }
}
