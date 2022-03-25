<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
