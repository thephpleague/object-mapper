<?php

declare(strict_types=1);

namespace League\ObjectMapper;

use ReflectionMethod;
use ReflectionParameter;

interface PropertyTypeResolver
{
    public function typeFromConstructorParameter(
        ReflectionParameter $parameter,
        ReflectionMethod $constructor
    ): PropertyType;
}
