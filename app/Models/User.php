<?php

namespace App\Models;

// Impor untuk relasi
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Ditambahkan 'role' agar bisa diisi saat register atau seeding.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // WAJIB: Kolom role ditambahkan di sini
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
        'password' => 'hashed',
    ];

    // =======================================================
    // DEFINISI RELASI
    // =======================================================

    /**
     * Relasi One-to-Many: Satu User memiliki banyak Task.
     */
    public function tasks(): HasMany
    {
        // Model Task
        return $this->hasMany(Task::class); 
    }
}