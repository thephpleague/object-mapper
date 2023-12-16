<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

#[ExampleData(['child' => ['name' => 'Frank']])]
final class ClassThatContainsAnotherClass
{
    public function __construct(
        public ClassWithUnmappedStringProperty $child
    ) {
    }
}
