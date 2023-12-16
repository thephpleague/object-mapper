<?php

declare(strict_types=1);

namespace League\ObjectMapper\IntegrationTests;

use const PHP_VERSION;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\ObjectMapperCodeGenerator;
use League\ConstructFinder\ConstructFinder;
use function array_push;
use function class_exists;
use function file_put_contents;
use function unlink;
use function version_compare;

class HydratingSerializedObjectsUsingCodeGenerationTest extends HydratingSerializedObjectsTestCase
{
    public function objectMapper(): ObjectMapper
    {
        $className = 'AcmeCorp\\GeneratedHydrator';

        if (class_exists($className)) {
            goto make_it;
        }

        $classes = $this->findClasses();
        $dumper = new ObjectMapperCodeGenerator();
        $code = $dumper->dump($classes, $className);

        file_put_contents(__DIR__ . '/testHydrator.php', $code);
        include __DIR__ . '/testHydrator.php';
        unlink(__DIR__ . '/testHydrator.php');

        make_it:

        return new $className();
    }

    private function findClasses(): array
    {
        $classes = ConstructFinder::locatedIn(__DIR__ . '/../Fixtures')->findClassNames();

        if (version_compare(PHP_VERSION, '8.1.0', '>=')) {
            array_push($classes, ...ConstructFinder::locatedIn(__DIR__ . '/../FixturesFor81')->findClassNames());
        }

        return $classes;
    }
}
