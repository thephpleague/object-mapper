<?php
declare(strict_types=1);

namespace League\ObjectMapper;

interface DefinitionProvider
{
    public function provideHydrationDefinition(string $className): ClassHydrationDefinition;

    public function provideSerializationDefinition(string $className): ClassSerializationDefinition;

    public function provideSerializer(string $type): ?array;

    public function allSerializers(): array;

    public function hasSerializerFor(string $name): bool;
}