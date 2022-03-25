<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $table="comments";
    protected $fillable = ['comments'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(blog::class);
    }

    public function commentblog()
    {
        return $this->belongsTo(commentBlog::class);
    }
}
