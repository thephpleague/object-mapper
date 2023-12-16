<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\PropertyCasters\CastListToType;

#[ExampleData(['children' => [['name' => 'Frank'], ['name' => 'Renske'], ['name' => 'Rover']]])]
final class ClassWithPropertyThatUsesListCastingToClasses
{
    public function __construct(
        #[CastListToType(ClassWithUnmappedStringProperty::class)]
        public array $children,
    ) {
    }
}
