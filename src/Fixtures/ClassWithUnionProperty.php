<?php

declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassWithUnionProperty
{
    public function __construct(
        public ClassReferencedByUnionOne|ClassReferencedByUnionTwo $union,
        public int|string $builtInUnion,
        public int|ClassReferencedByUnionOne $mixedUnion,
        public null|int|ClassReferencedByUnionOne $nullableMixedUnion,
        public null|ClassReferencedByUnionOne $nullableViaUnion,
    ) {
    }
}
