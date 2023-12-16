<?php

declare(strict_types=1);

namespace League\ObjectMapper\PropertySerializers;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertySerializer;
use function assert;
use function is_array;
use function is_object;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class SerializeArrayItems implements PropertySerializer
{
    public function serialize(mixed $value, ObjectMapper $mapper): mixed
    {
        assert(is_array($value));

        foreach ($value as $index => $item) {
            if (is_object($item)) {
                $value[$index] = $mapper->serializeObject($item);
            }
        }

        return $value;
    }
}
