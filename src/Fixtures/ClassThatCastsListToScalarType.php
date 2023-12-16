<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\PropertyCasters\CastListToType;

class ClassThatCastsListToScalarType
{
    /**
     * @param string[] $test
     */
    public function __construct(
        #[CastListToType('string')]
        public array $test,
    ) {
    }
}