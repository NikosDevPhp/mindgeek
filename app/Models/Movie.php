<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function casts(): BelongsToMany
    {
        return $this->belongsToMany(Cast::class)->withTimestamps();
    }

    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Director::class)->withTimestamps();
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class)->withTimestamps();
    }

}
