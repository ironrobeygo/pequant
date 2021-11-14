<?php

namespace App\Models;

use App\Models\Chapter;
use App\Scopes\OrderScope;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model implements HasMedia
{
    use HasFactory, SoftDeletes;
    use InteractsWithMedia;

    CONST ACTIVE  = 1;
    CONST INACTIVE = 0;

    protected $fillable = [
        'name',
        'type',
        'content',
        'user_id',
        'updated_by',
        'status', 
        'order'
    ];

    protected static function boot()
    {
        parent::boot();
  
        static::addGlobalScope(new OrderScope);
    }

    public function path(){
        return "/api/courses/{$this->chapter->course_id}/chapters/{$this->chapter->id}/units/{$this->id}";
    }

    public function setTypeAttribute($value){
        $this->attributes['type'] = 'unit';
    }

    public function chapter(){
        return $this->belongsTo(Chapter::class);
    }

}
