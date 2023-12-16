<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use DateTimeImmutable;

class ClassWithNotCastedDateTimeInput
{
    public function __construct(
        public DateTimeImmutable $date
    ) {
    }
}
