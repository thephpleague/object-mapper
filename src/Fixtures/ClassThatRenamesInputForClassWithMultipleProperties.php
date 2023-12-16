<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\MapFrom;

#[ExampleData(['mapped_age' => 34, 'name' => 'Frank'])]
final class ClassThatRenamesInputForClassWithMultipleProperties
{
    public function __construct(
        #[MapFrom(['mapped_age' => 'age', 'name'])]
        public ClassWithMultipleProperties $child,
    ) {
    }
}
