<?php
declare(strict_types=1);

namespace League\ObjectMapper;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class DoNotSerialize
{
}