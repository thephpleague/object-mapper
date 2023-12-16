<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassWithCamelCasePublicMethod
{
    public function __construct(private string $camelCase)
    {
    }

    public function camelCase(): string
    {
        return $this->camelCase;
    }
}
