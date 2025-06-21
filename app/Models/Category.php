<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke post (satu kategori bisa punya banyak post)
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
