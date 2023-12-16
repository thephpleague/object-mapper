<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassWithNullableProperty
{
    public function __construct(public ?string $defaultsToNull)
    {
    }
}
