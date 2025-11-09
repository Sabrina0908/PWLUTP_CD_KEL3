<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     * Admin akan mengatur 'name' dan 'color_code'.
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'color_code'
    ];

    // Definisikan relasi One-to-Many ke Task
    public function tasks(): HasMany
    {
        // Satu Priority dapat memiliki banyak Task
        return $this->hasMany(Task::class);
    }
}