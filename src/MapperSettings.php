<?php
declare(strict_types=1);

namespace League\ObjectMapper;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class MapperSettings
{
    public function __construct(
        public bool $serializePublicMethods = true,
        public bool $serializePublicProperties = true,
    ) {
    }
}