<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\Fixtures\ClassWithCamelCaseProperty as CamelClass;
use League\ObjectMapper\PropertyCasters\CastListToType;

class ClassThatCastsListsToDifferentTypes
{
    /**
     * @param CamelClass[] $first
     */
    public function __construct(
        #[CastListToType(CamelClass::class)]
        public array $first,

        #[CastListToType(ClassWithPropertyCasting::class)]
        public array $second,
    ) {
    }
}
