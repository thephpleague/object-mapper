<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

final class ClassWithCamelCaseProperty
{
    public function __construct(public string $snakeCase)
    {
    }
}
