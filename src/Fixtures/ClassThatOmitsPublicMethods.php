<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\MapperSettings;

#[MapperSettings(serializePublicMethods: false)]
class ClassThatOmitsPublicMethods
{
    public function __construct(
        public string $included = "included!"
    ) {
    }

    public function excluded(): string
    {
        return "excluded!";
    }
}