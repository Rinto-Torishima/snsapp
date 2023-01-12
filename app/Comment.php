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
}
