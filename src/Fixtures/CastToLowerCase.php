<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertyCaster;
use function strtolower;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class CastToLowerCase implements PropertyCaster
{
    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        return strtolower((string) $value);
    }
}
