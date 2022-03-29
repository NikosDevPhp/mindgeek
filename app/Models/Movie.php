<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function cardImages(): HasMany
    {
        return $this->hasMany(Image::class)->where('type', 'cardImage');
    }

    public function keyArtImages(): HasMany
    {
        return $this->hasMany(Image::class)->where('type', 'keyArtImage');
    }

    // TODO: can also be a many to many relationship
    public function gallery(): HasOne
    {
        return $this->hasOne(Gallery::class);
    }

}
