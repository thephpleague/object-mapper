<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\MapFrom;

#[ExampleData(['value' => 'yes', 'age' => 34, 'name' => 'Frank'])]
final class ClassThatUsesClassWithMultipleProperties
{
    public function __construct(
        public string $value,
        #[MapFrom(['age', 'name'])]
        public ClassWithMultipleProperties $child,
    ) {
    }
}
