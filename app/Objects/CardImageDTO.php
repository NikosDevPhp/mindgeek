<?php

namespace App\Objects;
use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;
use Illuminate\Support\Collection;

class CardImageDTO extends BaseDTO
{
    #[Field('url')] #[Validate('string')]
    public string $url;

    #[Field('h')] #[Validate('numeric')]
    public string $height;

    #[Field('w')] #[Validate('numeric')]
    public string $width;

    #[Field('path')] #[Validate('string')]
    public string $path;

    public string $type = 'cardImage';

    protected function feedKey(): string
    {
        return 'cardImages';
    }


}
