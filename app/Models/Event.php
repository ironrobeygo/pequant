<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'description',
        'start',
        'end',
        'user_id',
        'course_id'
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
