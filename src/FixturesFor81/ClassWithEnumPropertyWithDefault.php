<?php

namespace League\ObjectMapper\FixturesFor81;

final class ClassWithEnumPropertyWithDefault
{
    public function __construct(
        public readonly CustomEnum $enum = CustomEnum::VALUE_ONE,
    ) {
    }
}
