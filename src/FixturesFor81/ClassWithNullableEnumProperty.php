<?php

namespace League\ObjectMapper\FixturesFor81;

use League\ObjectMapper\Fixtures\CastEmptyStringToNull;

final class ClassWithNullableEnumProperty
{
    public function __construct(
        public readonly ?CustomEnum $enum,

        #[CastEmptyStringToNull]
        public readonly ?CustomEnum $enumFromEmptyString,
    ) {
    }
}
