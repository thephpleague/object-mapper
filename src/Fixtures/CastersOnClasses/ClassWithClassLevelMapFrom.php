<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures\CastersOnClasses;

use League\ObjectMapper\MapFrom;

#[MapFrom('nested')]
class ClassWithClassLevelMapFrom
{
    public function __construct(public string $name)
    {
    }
}