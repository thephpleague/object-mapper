<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures\CastersOnClasses;

use League\ObjectMapper\MapFrom;

#[MapFrom(['first' => 'one', 'second' => 'two'])]
class ClassWithClassLevelMapFromMultiple
{
    public function __construct(
        public int $one,
        public int $two,
    ) {
    }
}