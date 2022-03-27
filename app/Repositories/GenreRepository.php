<?php

namespace App\Repositories;

use App\Models\Genre;

class GenreRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Genre::class;
    }
}
