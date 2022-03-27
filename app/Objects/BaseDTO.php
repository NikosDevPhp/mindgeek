<?php

namespace App\Objects;

use App\Attributes\Feed\Field;
use App\Attributes\Feed\Validate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use ReflectionProperty;

abstract class BaseDTO
{
    protected function feedKey(): ?string
    {
        return null;
    }

    public function populateFromArray(array $data): ?self
    {
        $reflection = new \ReflectionObject($this);
        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {

            // skip properties without attributes
            try {
                $propertyField = $property->getAttributes(Field::class)[0];
            } catch (\ErrorException $e) {
                continue;
            }

            $feedField = $propertyField->getArguments()[0];

            // check that attributes declaration in class properties is valid
            if (!is_string($feedField)) {
                Log::error('Malformed attribute for ' . $property->getName());
                return null;
            }


            // check if attribute exists in feed else do not initialize
            if (!isset($data[$feedField])) {
                continue;
            }

            $attributes = $property->getAttributes();
            foreach ($attributes as $attribute) {
                $input = $attribute->newInstance()->input;

                // set the property field
                if ($attribute->getName() === Field::class) {
                    $this->{$property->getName()} = $data[$input];
                }

                // run the validations
                if ($attribute->getName() === Validate::class) {
                    $v = validator($data, [$feedField => $attribute->newInstance()->input]);
                    if ($v->fails()) {
                        Log::error('Invalid data provided for field ' . $property->getName());
                        return null;
                    }
                }
            }

        }
        return $this;
    }

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
