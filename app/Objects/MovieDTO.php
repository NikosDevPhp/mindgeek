<?php

namespace App\Objects;
use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;

class MovieDTO extends BaseDTO
{
    #[Field('body')] #[Validate('string')]
    public string $body;

    #[Field('cert')] #[Validate('string')]
    public string $cert;

    #[Field('class')] #[Validate('string')]
    public string $class;

    #[Field('duration')] #[Validate('numeric')]
    public int $duration;

    #[Field('headline')] #[Validate('string')]
    public string $headline;

    #[Field('id')] #[Validate('required|string')]
    public string $feedId;

    #[Field('lastUpdated')] #[Validate('date_format:Y-m-d')]
    public string $lastUpdated;

    #[Field('quote')] #[Validate('string')]
    public string $quote;

    #[Field('rating')] #[Validate('numeric')]
    public int $rating;

    #[Field('reviewAuthor')] #[Validate('string')]
    public string $reviewAuthor;

    #[Field('skyGoId')] #[Validate('string')]
    public string $skyGoId;

    #[Field('skyGoUrl')] #[Validate('string')]
    public string $skyGoUrl;

    #[Field('sum')] #[Validate('string')]
    public string $sum;

    #[Field('url')] #[Validate('string')]
    public string $url;

    #[Field('year')] #[Validate('numeric')]
    public string $year;


    public function populateFromArray(array $data): ?self
    {
        parent::populateFromArray($data);

        // attach viewingWindow properties in object instance
        if (isset($data['viewingWindow'])) {
            $viewingWindow = app()->make(ViewingWindowDTO::class)->populateFromArray($data['viewingWindow']);

            if (!is_null($viewingWindow)) {
                foreach (get_object_vars($viewingWindow) as $property => $value) {
                    $this->$property = $value;
                }
            }
        }

        return $this;
    }
}
