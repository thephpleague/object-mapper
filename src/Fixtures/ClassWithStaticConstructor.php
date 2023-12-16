<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\Constructor;

#[ExampleData(['name' => 'Frank'])]
final class ClassWithStaticConstructor
{
    private function __construct(public string $name)
    {
    }

    #[Constructor]
    public static function buildMe(string $name): static
    {
        return new static($name);
    }
}
