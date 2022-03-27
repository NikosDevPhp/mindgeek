<?php

namespace App\Repositories;

use App\Objects\MovieDTO;
use App\Models\Movie;

class MovieRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Movie::class;
    }

}
