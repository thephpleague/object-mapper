<?php

declare(strict_types=1);

namespace League\ObjectMapper;

class ObjectMapperUsingReflectionHydrationTest extends ObjectHydrationTestCase
{
    protected function createObjectMapper(DefinitionProvider $definitionProvider = null): ObjectMapper
    {
        $definitionProvider ??= new DefinitionProvider(
            keyFormatter: new KeyFormatterWithoutConversion()
        );

        return new ObjectMapperUsingReflection($definitionProvider);
    }
}
