<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

#[ExampleData(['child' => 'Rover (dog)'])]
final class ClassWithComplexTypeThatIsMapped
{
    public function __construct(
        #[CastToClassWithStaticConstructor]
        public ClassWithStaticConstructor|ClassWithUnmappedStringProperty $child
    ) {
    }
}
