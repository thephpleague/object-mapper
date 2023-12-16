<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

use League\ObjectMapper\DoNotSerialize;

class ClassThatOmitsSpecificMethodsAndProperties
{
    public function __construct(
        #[DoNotSerialize]
        public string $omittedProperty = 'omitted property',
        public string $includedProperty = 'included property',
    )
    {
    }

    public function includedMethodField(): string
    {
        return 'included method value';
    }

    #[DoNotSerialize]
    public function excludedMethodField(): string
    {
        return 'excluded method value';
    }
}