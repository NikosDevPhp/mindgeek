<?php

namespace App\Objects;
use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;

class KeyArtImageDTO extends BaseDTO
{
    #[Field('url')] #[Validate('string')]
    public string $url;

    #[Field('h')] #[Validate('numeric')]
    public string $height;

    #[Field('w')] #[Validate('numeric')]
    public string $width;

    #[Field('path')] #[Validate('string')]
    public string $path;

    public string $type = 'keyArtImage';

    protected function feedKey(): string
    {
        return 'keyArtImages';
    }

}
