<?php

declare(strict_types=1);

namespace League\ObjectMapper\PropertySerializers;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertySerializer;
use LogicException;
use Ramsey\Uuid\UuidInterface;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class SerializeUuidToString implements PropertySerializer
{
    public function __construct(private string $type = 'string')
    {
    }

    public function serialize(mixed $value, ObjectMapper $mapper): mixed
    {
        assert($value instanceof UuidInterface);

        return match ($this->type) {
            'string' => $value->toString(),
            'bytes' => $value->getBytes(),
            'int' => $value->getInteger()->toString(),
            'integer' => $value->getInteger()->toString(),
            default => throw new LogicException('Unexpected UUID type: ' . $this->type),
        };
    }
}
