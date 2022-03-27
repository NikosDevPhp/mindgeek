<?php

namespace App\Repositories;

use App\Models\Director;

class DirectorRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Director::class;
    }

}
