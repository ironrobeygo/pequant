<?php

namespace App\Models;

use App\Models\Chapter;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    CONST ACTIVE  = 1;
    CONST INACTIVE = 0;

    CONST APPROVED = 1;
    CONST REJECTED = 0;

    protected $fillable = [
        'name',
        'module_id',
        'user_id',
        'updated_by',
        'status'
    ];

    public function path(){
        return "/api/courses/{$this->module->course_id}/modules/{$this->module->id}/quizzes/{$this->id}";
    }

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function addQuestion($data){
        return $this->questions()->create($data);
    }

    public function scopeGetQuizTotal($query){
        return $this->questions()->where('status', 1)->whereIn('user_id', array(1,2,3,4))->sum('weight');
    }

    public function completed(){
        return $this->completed == 0 ? true : false;
    }
}
