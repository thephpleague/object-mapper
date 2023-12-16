<?php

declare(strict_types=1);

namespace League\ObjectMapper;

interface PropertySerializer
{
    public function serialize(mixed $value, ObjectMapper $mapper): mixed;
}
