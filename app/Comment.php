<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment_message',
        'comment_name'

    ];
    public function topic()
    {
        return $this->belongsTo("App\Topic");
    }
    public function likes()
    {
        return $this->hasMany("App\Like");
    }
    public function isLikedBy($user): bool
    {
        return Like::where('user_id', $user->id)->where('comment_id', $this->id)->first() !== null;
    }
}
