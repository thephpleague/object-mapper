<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassReferencedByUnionTwo
{
    public function __construct(public string $text)
    {
    }
}
