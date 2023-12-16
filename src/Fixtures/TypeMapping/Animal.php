<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures\TypeMapping;

use League\ObjectMapper\MapFrom;
use League\ObjectMapper\MapToType;

#[MapFrom('nested')]
#[MapToType(
    key: 'muppet',
    map: [
        'rowlf' => Dog::class,
        'kermit' => Frog::class,
    ]
)]
interface Animal
{
    public function speak(): string;
}