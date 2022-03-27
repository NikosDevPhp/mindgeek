<?php

namespace App\Objects;
use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;

class DirectorDTO extends BaseDTO
{
    #[Field('name')] #[Validate('string')]
    public string $name;

    protected function feedKey(): string
    {
        return 'directors';
    }

}
