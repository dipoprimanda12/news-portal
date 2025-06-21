<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Uncomment jika kamu memang menggunakan Sanctum
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Aktifkan HasApiTokens hanya jika kamu pakai Sanctum (API token login)
    // use HasApiTokens,
    use HasFactory, Notifiable;

    /**
     * Atribut yang bisa diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Atribut yang disembunyikan saat model dikonversi ke array atau JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang perlu dikonversi secara otomatis ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Mutator otomatis untuk hashing password saat diset.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = \Illuminate\Support\Str::startsWith($value, '$2y$')
                ? $value
                : bcrypt($value);
        }
    }

    /**
     * Relasi: User memiliki banyak post.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    /**
     * Relasi: User memiliki banyak komentar.
     */public function comments()
{
    return $this->hasMany(Comment::class);
}
}
