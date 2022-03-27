<?php

namespace App\Objects;
use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;
use Illuminate\Support\Collection;

class GalleryDTO extends BaseDTO
{
    #[Field('title')] #[Validate('string')]
    public string $title;

    #[Field('url')] #[Validate('string')]
    public string $url;

    #[Field('thumbnailUrl')] #[Validate('string')]
    public string $thumbnailUrl;

    #[Field('id')] #[Validate('string')]
    public string $feedId;

    protected function feedKey(): string
    {
        return 'galleries';
    }

}
