<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassWithListOfObjects
{
    public function __construct(public array $children)
    {
    }
}
