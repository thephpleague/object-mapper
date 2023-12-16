<?php

declare(strict_types=1);

namespace League\ObjectMapper\FixturesFor81;

class ClassWithIntegerEnumProperty
{
    public function __construct(public readonly IntegerEnum $enum)
    {
    }
}
