<?php

namespace App\Attributes\Feed;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Field
{
    public function __construct(public string $input) {}
}
