<?php

declare(strict_types=1);

namespace League\ObjectMapper\PropertyCasters;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertyCaster;
use League\ObjectMapper\PropertySerializer;
use function is_object;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
final class CastToArrayWithKey implements PropertyCaster, PropertySerializer
{
    public function __construct(private string $key)
    {
    }

    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        return [$this->key => $value];
    }

    public function serialize(mixed $value, ObjectMapper $mapper): mixed
    {
        if (is_object($value)) {
            $value = $mapper->serializeObject($value);
        }

        return $value[$this->key] ?? null;
    }
}
