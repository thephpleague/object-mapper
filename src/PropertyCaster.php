<?php

declare(strict_types=1);

namespace League\ObjectMapper;

interface PropertyCaster
{
    public function cast(mixed $value, ObjectMapper $mapper): mixed;
}
