<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory;

    CONST ACTIVE  = 1;
    CONST INACTIVE = 0;

    protected $fillable = [
        'user_id',
        'name',
        'announcement',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function active(){
        return $this->status == self::ACTIVE;
    }
}
