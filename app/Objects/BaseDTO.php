<?php

namespace App\Objects;

use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use ReflectionProperty;

abstract class BaseDTO
{
    /**
     * Override in child class to specify the key name in the feed
     * @return string|null
     */
    protected function feedKey(): ?string
    {
        return null;
    }

    /**
     * Populate DTO fields checking `field` existence and running validations
     * skipping any field that are invalid/do not exist
     * @param array $data
     * @return $this|null
     */
    public function populateFromArray(array $data): ?self
    {
        $reflection = new \ReflectionObject($this);
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {

            // skip properties without attributes
            try {
                $propertyField = $property->getAttributes(Field::class)[0];
                $propertyValidate = $property->getAttributes(Validate::class)[0];
            } catch (\ErrorException $e) {
                Log::info('Property with no attributes skipped: ' . $property->getName());
                continue;
            }

            $feedField = $propertyField->getArguments()[0];
            $validateField = $propertyValidate->getArguments()[0];

            // check that attributes declaration in class properties is valid
            if (!is_string($feedField) || !is_string($validateField)) {
                Log::error('Malformed attribute for ' . $property->getName());
                continue;
            }

            // check if attribute exists in feed else do not initialize
            if (!isset($data[$feedField])) {
                continue;
            }

            $input = $propertyValidate->newInstance()->input;
            $v = validator($data, [$feedField => $input]);
            if ($v->fails()) {
                Log::error('Invalid data provided for field ' . $property->getName());
                continue;
            }

            // if everything is ok initialize the property and assign the value
            $input = $propertyField->newInstance()->input;
            $this->{$property->getName()} = $data[$input];

        }

        return $this;
    }

    /**
     * Populates a collection of DTOs
     * @param array $data
     * @return Collection|null
     */
    public function populateFromCollection(array $data): ?Collection
    {
        $return = collect();
        if ($this->feedKey()) {
            $data = $data[$this->feedKey()] ?? [];
        }
        foreach ($data as $dat) {
            $return->add((new static())->populateFromArray($dat));
        }
        return $return;
    }
}
