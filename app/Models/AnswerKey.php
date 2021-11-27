<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnswerKey extends Model
{
    use HasFactory;

    protected $table = 'answer_question';

    protected $fillable = [
        'answer',
        'question_id',
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
