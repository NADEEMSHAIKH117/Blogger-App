<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commentBlog extends Model
{
    use HasFactory;
    protected $table="comment_blogs";
    protected $fillable = ['blog_id','comment_id'];

    public function blog()
    {
        return $this->belongsTo(blog::class);
    }

    public function comment()
    {
        return $this->belongsTo(blog::class);
    }
}
