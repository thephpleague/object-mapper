<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\PropertyCasters\CastListToType;

#[ExampleData(['ages' => ['1234', '2345', '3456']])]
final class ClassWithPropertyThatUsesListCasting
{
    public function __construct(
        #[CastListToType('int')]
        public array $ages,
    ) {
    }
}
