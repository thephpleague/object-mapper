<?php

declare(strict_types=1);

namespace League\ObjectMapper\Benchmarks;

use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\ObjectMapperUsingReflection;

class ReflectionHydrationBench extends HydrationBenchCase
{
    protected function createObjectMapper(): ObjectMapper
    {
        return new ObjectMapperUsingReflection();
    }
}
