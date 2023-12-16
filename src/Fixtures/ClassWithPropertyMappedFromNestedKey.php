<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\MapFrom;

#[ExampleData(['nested' => ['name' => 'Frank']])]
class ClassWithPropertyMappedFromNestedKey
{
    public function __construct(
        #[MapFrom('nested.name', separator: '.')]
        public string $name
    ) {
    }
}
