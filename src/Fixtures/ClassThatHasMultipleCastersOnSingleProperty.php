<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\PropertyCasters\CastToArrayWithKey;
use League\ObjectMapper\PropertyCasters\CastToType;

#[ExampleData(['child' => 12345])]
final class ClassThatHasMultipleCastersOnSingleProperty
{
    public function __construct(
        #[CastToType('string', 'int')]
        #[CastToArrayWithKey('name')]
        public ClassWithStaticConstructor $child,
    ) {
    }
}
