<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'options';

    public function question(){
        return $this->belongsToMany(Question::class, 'answer_question', 'option_id', 'question_id');
    }
}
