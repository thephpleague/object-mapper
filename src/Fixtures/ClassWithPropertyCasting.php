<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\PropertyCasters\CastToType;

#[ExampleData(['age' => '34'])]
final class ClassWithPropertyCasting
{
    public function __construct(
        #[CastToType(propertyType: 'int', serializedType: 'string')]
        public int $age,
    ) {
    }
}
