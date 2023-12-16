<?php

namespace League\ObjectMapper\Fixtures;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertyCaster;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CastEmptyStringToNull implements PropertyCaster
{
    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        if ($value === '') {
            return null;
        }

        return $value;
    }
}
