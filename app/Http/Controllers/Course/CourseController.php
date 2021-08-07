<?php

namespace App\Http\Controllers\Course;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index(){
        return view('admin.courses.index');
    }

    public function create(){
        return view('admin.courses.add');   
    }

    public function store(){

        $validated = request()->validate([
            'name'          => 'required',
            'description'   => 'nullable',
            'category_id'   => 'required',
            'updated_by'    => 'required',
            'status'        => 'required',
            'isOnline'      => 'required'
        ]);

        $course = auth()->user()->addCourse($validated); 

        if( request()->has('institution_ids') ){
            $course->syncInstitutions(request()->institutions);
        }

        if( request()->has('instructor_ids') ){
            $course->syncInstructors(request()->instructors);
        }

        return $course;
  
    }

    public function show(Course $course){
        if(auth()->user()->hasRole('student')){
            return view('course.students.show', compact('course'));
        }
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course){
        return view('admin.courses.edit', compact('course'));
    }
}
