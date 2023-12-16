<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use DateTimeImmutable;
use League\ObjectMapper\PropertyCasters\CastToDateTimeImmutable;

#[ExampleData(['date' => '24-11-1987'])]
final class ClassWithFormattedDateTimeInput
{
    public function __construct(
        #[CastToDateTimeImmutable('!d-m-Y', 'Europe/Amsterdam')]
        public DateTimeImmutable $date
    ) {
    }
}
