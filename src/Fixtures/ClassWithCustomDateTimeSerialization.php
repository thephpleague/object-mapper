<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use League\ObjectMapper\PropertySerializers\SerializeDateTime;

class ClassWithCustomDateTimeSerialization
{
    #[SerializeDateTime(format: 'd-m-Y')]
    public DateTimeInterface $regularPublicProperty;

    private DateTime $getterProperty;

    public function __construct(
        #[SerializeDateTime(format: 'd-m-Y')]
        public DateTimeImmutable $promotedPublicProperty,
        DateTimeInterface $regularPublicProperty,
        DateTime $getterProperty
    ) {
        $this->regularPublicProperty = $regularPublicProperty;
        $this->getterProperty = $getterProperty;
    }

    #[SerializeDateTime(format: 'd-m-Y')]
    public function getterProperty(): DateTime
    {
        return $this->getterProperty;
    }
}
