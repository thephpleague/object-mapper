<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\Fixtures\ClassWithCamelCaseProperty as CamelClass;

class ClassThatCastsListsToBasedOnDocComments
{
    /**
     * @param CamelClass[]              $list
     * @param array<string, CamelClass> $map
     * @param array<CamelClass>         $array
     */
    public function __construct(
        public array $list,
        public array $map,
        public array $array,
    ) {
    }
}
