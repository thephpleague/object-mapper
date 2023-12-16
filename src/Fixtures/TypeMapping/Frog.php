<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures\TypeMapping;

class Frog implements Animal
{
    public function __construct(public string $color)
    {
    }

    public function speak(): string
    {
        return 'ribbit';
    }
}