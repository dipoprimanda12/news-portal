<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke user (penulis)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Relasi ke komentar
     */public function comments()
{
    return $this->hasMany(Comment::class);
}
}
