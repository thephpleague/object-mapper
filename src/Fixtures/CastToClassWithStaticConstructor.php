<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertyCaster;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class CastToClassWithStaticConstructor implements PropertyCaster
{
    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        return $mapper->hydrateObject(ClassWithStaticConstructor::class, ['name' => $value]);
    }
}
