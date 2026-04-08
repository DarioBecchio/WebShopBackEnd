<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'phone',
        'birth_date',
        'address',
        'city',
        'postal_code',
        'country',
        'avatar',
        'newsletter',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date'        => 'date',
        'newsletter'        => 'boolean',
        'password' => 'hashed',
    ];
    // Relazione con i post (se l'utente è admin)
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isAdmin(): bool
{
    return $this->role === 'admin';
}
}
