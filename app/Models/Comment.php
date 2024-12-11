<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $fillable = ['content', 'commentable_type', 'commentable_id', 'approved'];
    protected $casts =[
        'content'=> 'string',
    ];
    public function commentable()
    {
        return $this->morphTo();
    }
}