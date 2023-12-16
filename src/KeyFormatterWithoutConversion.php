<?php

declare(strict_types=1);

namespace League\ObjectMapper;

class KeyFormatterWithoutConversion implements KeyFormatter
{
    public function propertyNameToKey(string $propertyName): string
    {
        return $propertyName;
    }

    public function keyToPropertyName(string $key): string
    {
        return $key;
    }
}
