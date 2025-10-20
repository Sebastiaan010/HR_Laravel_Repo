<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['forum_post_id','user_id','body'];

    public function post() { return $this->belongsTo(\App\Models\ForumPost::class, 'forum_post_id'); }
    public function user() { return $this->belongsTo(\App\Models\User::class); }
}
