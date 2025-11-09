<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     * Sudah diperbaiki: 'description' diganti menjadi 'notes'.
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'priority_id',
        'title',
        'notes', // <--- INI SUDAH BENAR: Mencocokkan nama kolom di database
        'is_completed',
    ];

    /**
     * Casting kolom is_completed ke boolean.
     * @var array<string, string>
     */
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    // Definisikan relasi BelongsTo ke User
    public function user(): BelongsTo
    {
        // Task dimiliki oleh satu User
        return $this->belongsTo(User::class);
    }

    // Definisikan relasi BelongsTo ke Priority
    public function priority(): BelongsTo
    {
        // Task memiliki satu Priority
        return $this->belongsTo(Priority::class);
    }
}