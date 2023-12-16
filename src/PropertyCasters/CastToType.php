<?php

declare(strict_types=1);

namespace League\ObjectMapper\PropertyCasters;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertyCaster;
use League\ObjectMapper\PropertySerializer;
use function settype;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
final class CastToType implements PropertyCaster, PropertySerializer
{
    public function __construct(
        private string $propertyType,
        private ?string $serializedType = null,
    ) {
    }

    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        settype($value, $this->propertyType);

        return $value;
    }

    public function serialize(mixed $value, ObjectMapper $mapper): mixed
    {
        if ($this->serializedType) {
            settype($value, $this->serializedType);
        }

        return $value;
    }
}
