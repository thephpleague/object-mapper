<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\PropertyCasters\CastToUuid;
use Ramsey\Uuid\UuidInterface;

#[ExampleData(['id' => '9f960d77-7c9b-4bfd-9fc4-62d141efc7e5'])]
class ClassWithUuidProperty
{
    public function __construct(
        #[CastToUuid]
        public UuidInterface $id,
    ) {
    }
}
