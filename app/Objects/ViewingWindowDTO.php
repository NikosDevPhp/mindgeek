<?php

namespace App\Objects;
use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;

class ViewingWindowDTO extends BaseDTO
{
    #[Field('title')] #[Validate('string')]
    public string $viewingTitle;

    #[Field('startDate')] #[Validate('date_format:Y-m-d')]
    public string $viewingStartDate;

    #[Field('endDate')] #[Validate('date_format:Y-m-d')]
    public string $viewingEndDate;

    #[Field('wayToWatch')] #[Validate('string')]
    public string $viewingWayToWatch;

    protected function feedKey(): string
    {
        return 'viewingWindow';
    }

}
