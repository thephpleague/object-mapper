<?php

declare(strict_types=1);

namespace League\ObjectMapper\FixturesFor81;

class ClassWithEnumProperty
{
    public function __construct(
        public readonly CustomEnum $enum,
    ) {
    }
}
