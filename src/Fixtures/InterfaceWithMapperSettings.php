<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\MapperSettings;

#[MapperSettings(serializePublicMethods: false)]
interface InterfaceWithMapperSettings
{
    public function isMapped(): string;
}
