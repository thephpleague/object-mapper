<?php

declare(strict_types=1);

namespace League\ObjectMapper;

/**
 * @internal
 */
class ClassSerializationDefinition
{
    public function __construct(
        /**
         * @var PropertySerializationDefinition[]
         */
        public array $properties,
        public ?string $typeKey,
        public array $typeMap,
        public false|array $mapFrom,
    ) {
    }
}
