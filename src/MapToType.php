<?php

declare(strict_types=1);

namespace League\ObjectMapper;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY | Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class MapToType
{
    public function __construct(
        public string $key = 'type',
        /**
         * @var array<string, class-string>
         */
        public array $map = [],
    ) {
    }
}
