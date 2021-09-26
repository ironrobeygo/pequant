<?php

namespace App\Models;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
