<?php

namespace App\Repositories;

use App\Models\Cast;

class CastRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Cast::class;
    }
}
