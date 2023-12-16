<?php

declare(strict_types=1);

namespace League\ObjectMapper\IntegrationTests;

use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\ObjectMapperUsingReflection;

class HydratingSerializedObjectsUsingReflectionTest extends HydratingSerializedObjectsTestCase
{
    public function objectMapper(): ObjectMapper
    {
        return new ObjectMapperUsingReflection();
    }
}
