<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\MapFrom;

#[ExampleData(['my_name' => 'Frank'])]
final class ClassWithMappedStringProperty
{
    public function __construct(
        #[MapFrom('my_name')]
        public string $name,
    ) {
    }
}
