<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Chapter;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'units';

    CONST ACTIVE  = 1;
    CONST INACTIVE = 0;

    CONST APPROVED = 1;
    CONST REJECTED = 0;

    protected $fillable = [
        'name',
        'type',
        'content',
        'user_id',
        'updated_by',
        'expires_at',
        'status'
    ];

    public function path(){
        return "/api/courses/{$this->module->course_id}/modules/{$this->module->id}/quizzes/{$this->id}";
    }

    public function setTypeAttribute($value){
        $this->attributes['type'] = 'quiz';
    }
    public function setContentAttribute($value){
        $this->attributes['content'] = 'empty content';
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
        $admins = User::getAdmins()->pluck('id')->toArray();
        array_push($admins, $this->chapter->course->instructor_id);
        return $this->questions()->where('status', 1)->whereIn('user_id', $admins)->sum('weight');
    }

    public function completed(){
        return $this->completed == 0 ? true : false;
    }

    public function isExpired(){

        if(!is_null($this->expires_at)){
            return !Carbon::parse($this->expires_at)->isFuture();            
        } else {
            return false;
        }

    }
}
