<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassWithPropertiesWithDefaultValues
{
    public function __construct(
        public ?string $nullableWithDefaultString = 'default_used',
        public string $notNullableWithDefaultString = 'default_string',
    )
    {
    }
}
