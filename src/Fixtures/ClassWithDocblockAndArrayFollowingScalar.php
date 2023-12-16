<?php
declare(strict_types=1);

namespace League\ObjectMapper\Fixtures;

class ClassWithDocblockAndArrayFollowingScalar
{
    /**
     * Constructor.
     *
     * @param string $test
     *   Param name.
     * @param string[] $test2
     *   Param 2 name.
     */
    public function __construct(
        public string $test,
        protected array $test2,
    ) {
    }
}
