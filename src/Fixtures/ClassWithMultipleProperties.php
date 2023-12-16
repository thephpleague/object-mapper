<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

#[ExampleData(['age' => 34, 'name' => 'Frank'])]
final class ClassWithMultipleProperties
{
    public function __construct(
        public int $age,
        public string $name,
    ) {
    }
}
