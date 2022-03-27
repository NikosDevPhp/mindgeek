<?php

namespace App\Repositories;

use App\Models\Gallery;

class GalleryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Gallery::class;
    }
}
