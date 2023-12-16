<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures\TypeMapping;

use League\ObjectMapper\MapToType;

class ClassThatMapsTypes
{
    public function __construct(
        #[MapToType('animal', [
            'frog' => Frog::class,
            'dog' => Dog::class,
        ])]
        public Animal $child
    ) {
    }
}