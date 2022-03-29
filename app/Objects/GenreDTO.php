<?php

namespace App\Objects;
use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;

class GenreDTO extends BaseDTO
{
    #[Field('')] #[Validate('string')]
    public string $name;

    protected function feedKey(): string
    {
        return 'genres';
    }

    /**
     * Override parent::populateFromArray
     * @param array|string $data
     * @return $this|null
     */
    public function populateFromArray(array|string $data): ?self
    {
        $this->name = $data;

        return $this;
    }

}
