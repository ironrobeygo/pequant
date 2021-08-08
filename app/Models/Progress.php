<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'unit_id'
    ];

    public function isCompleted(){
        return $this->completed_at !== null ? true : false;
    }
}
