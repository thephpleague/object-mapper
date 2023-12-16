<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassWithParentMappingSettings extends ClassThatOmitsPublicProperties
{
    public function __construct(
        public string $excluded = 'included!',
    ) {
    }
}
