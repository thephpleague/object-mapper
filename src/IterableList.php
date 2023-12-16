<?php

declare(strict_types=1);

namespace League\ObjectMapper;

use ArrayIterator;
use IteratorAggregate;
use Traversable;
use function iterator_to_array;

/**
 * @template T
 *
 * @internal
 */
class IterableList implements IteratorAggregate
{
    public function __construct(private iterable $objects)
    {
    }

    /**
     * @return Traversable<T>
     */
    public function getIterator(): Traversable
    {
        return $this->objects instanceof Traversable
            ? $this->objects
            : new ArrayIterator($this->objects);
    }

    /**
     * @return T[]
     */
    public function toArray(): array
    {
        return $this->objects instanceof Traversable
            ? iterator_to_array($this->objects, true)
            : (array) $this->objects;
    }
}
