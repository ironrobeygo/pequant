<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question',
        'type_id',
        'module_id',
        'user_id',
        'updated_by',
        'status',
        'weight'
    ];

    public function path(){

        return "/api/courses/{$this->quiz->module->course_id}/modules/{$this->quiz->module_id}/quizzes/{$this->quiz->id}/questions/{$this->id}";
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    public function answers(){
        return $this->belongsToMany(Answer::class, 'answer_question', 'question_id', 'option_id');
    }

    public function options(){
        return $this->belongsToMany(Option::class);
    }

    public function syncOptions($data){
        return $this->options()->sync($data);
    }

    public function syncAnswer($data){
        return $this->answers()->sync($data);
    }
}
