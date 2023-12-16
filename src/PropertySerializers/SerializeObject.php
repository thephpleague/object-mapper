<?php

declare(strict_types=1);

namespace League\ObjectMapper\PropertySerializers;

use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertySerializer;

class SerializeObject implements PropertySerializer
{
    public function serialize(mixed $value, ObjectMapper $mapper): mixed
    {
        return $mapper->serializeObject($value);
    }
}
