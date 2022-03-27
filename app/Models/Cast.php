<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cast extends Model
{
    use HasFactory;

    protected $table = 'cast';

    protected $guarded = ['id'];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class)->withTimestamps();
    }
}
