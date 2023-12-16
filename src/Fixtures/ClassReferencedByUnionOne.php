<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassReferencedByUnionOne
{
    public function __construct(public int $number)
    {
    }
}
