<?php

namespace League\ObjectMapper\FixturesFor81;

final class ClassWithNullableUnitEnumProperty
{
    public function __construct(
        public readonly ?OptionUnitEnum $enum,
    ) {
    }
}
