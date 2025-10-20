<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $fillable = ['title','body','user_id','locked','image_path'];
    public function comments() { return $this->hasMany(\App\Models\Comment::class); }

}
