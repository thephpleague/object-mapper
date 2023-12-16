<?php

declare(strict_types=1);

namespace League\ObjectMapper\IntegrationTests;

use League\ObjectMapper\Fixtures\ClassThatCastsListsToBasedOnDocComments;
use League\ObjectMapper\Fixtures\ClassThatCastsListsToDifferentTypes;
use League\ObjectMapper\Fixtures\ClassThatCastsListToScalarType;
use League\ObjectMapper\Fixtures\ClassThatHasMultipleCastersOnSingleProperty;
use League\ObjectMapper\Fixtures\ClassWithCamelCaseProperty;
use League\ObjectMapper\Fixtures\ClassWithPropertyCasting;
use League\ObjectMapper\Fixtures\ClassWithStaticConstructor;
use League\ObjectMapper\FixturesFor81\ClassWithEnumProperty;
use League\ObjectMapper\FixturesFor81\ClassWithIntegerEnumProperty;
use League\ObjectMapper\FixturesFor81\ClassWithUnitEnumProperty;
use League\ObjectMapper\FixturesFor81\CustomEnum;
use League\ObjectMapper\FixturesFor81\IntegerEnum;
use League\ObjectMapper\FixturesFor81\OptionUnitEnum;
use League\ObjectMapper\ObjectMapper;
use PHPUnit\Framework\TestCase;

abstract class HydratingSerializedObjectsTestCase extends TestCase
{
    abstract public function objectMapper(): ObjectMapper;

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function serializing_a_hydrated_class(string $className, array $input, array|null $types): void
    {
        $mapper = $this->objectMapper();

        $object = $mapper->hydrateObject($className, $input);
        $payload = $mapper->serializeObject($object);

        self::assertInstanceOf($className, $object);
        self::assertEquals($input, $payload);
        self::assertExpectedTypes($types ?? [], $object);
    }

    public static function dataProvider(): iterable
    {
        yield 'class that casts a list to a scalar type' => [
            ClassThatCastsListToScalarType::class,
            ['test' => ['Frank']],
            ['test' => ['type' => 'list', 'values' => 'string']],
        ];

        yield 'class with list type resolve from doc comment' => [
            ClassThatCastsListsToBasedOnDocComments::class,
            [
                'list' => [
                    ['snake_case' => 'Frank'],
                    ['snake_case' => 'Renske'],
                ],
                'map' => [
                    'one' => ['snake_case' => 'Frank'],
                    'two' => ['snake_case' => 'Renske'],
                ],
                'array' => [
                    1 => ['snake_case' => 'Frank'],
                    '2' => ['snake_case' => 'Renske'],
                ],
            ],
            [
                'list' => [
                    'type' => 'list',
                    'values' => ClassWithCamelCaseProperty::class,
                ],
                'map' => [
                    'type' => 'map',
                    'values' => ClassWithCamelCaseProperty::class,
                ],
                'array' => [
                    'type' => 'array',
                    'values' => ClassWithCamelCaseProperty::class,
                ],
            ],
        ];

        yield 'class with two lists' => [
            ClassThatCastsListsToDifferentTypes::class,
            [
                'first' => [
                    ['snake_case' => 'Frank'],
                    ['snake_case' => 'Renske'],
                ],
                'second' => [
                    ['age' => 34],
                    ['age' => 31],
                ],
            ],
            [
                'first' => ['type' => 'list', 'values' => ClassWithCamelCaseProperty::class],
                'second' => ['type' => 'list', 'values' => ClassWithPropertyCasting::class],
            ],
        ];

        yield 'class with property type convertion' => [
            ClassWithPropertyCasting::class,
            ['age' => '34'],
            ['age' => ['type' => 'integer']],
        ];

        yield 'class with property mapped to a key' => [
            ClassThatHasMultipleCastersOnSingleProperty::class,
            ['child' => 12345],
            ['child' => ['type' => ClassWithStaticConstructor::class]],
        ];

        if (version_compare(PHP_VERSION, '8.1.0', '>=')) {
            yield 'class with backed enum property' => [
                ClassWithEnumProperty::class,
                ['enum' => 'two'],
                ['enum' => ['type' => CustomEnum::class]],
            ];
            yield 'class with unit enum property' => [
                ClassWithUnitEnumProperty::class,
                ['enum' => 'OptionA'],
                ['enum' => ['type' => OptionUnitEnum::class]],
            ];
            yield 'class with integer enum property' => [
                ClassWithIntegerEnumProperty::class,
                ['enum' => 1],
                ['enum' => ['type' => IntegerEnum::class]],
            ];
        }
    }

    private static function assertExpectedTypes(array $types, object $object): void
    {
        foreach ($types as $property => $type) {
            $value = $object->$property;

            self::assertExpectedType($type['type'], $value);

            switch ($type['type']) {
                case 'map':
                case 'array':
                case 'list':
                    foreach ($value as $val) {
                        self::assertExpectedType($type['values'], $val);
                    }
                    break;
            }
        }
    }

    private static function assertExpectedType(string $expectedType, mixed $value): void
    {
        switch ($expectedType) {
            case 'array':
                self::assertIsArray($value);

                return;

            case 'list':
                self::assertArrayIsList($value);

                return;

            case 'map':
                self::assertArrayIsMap($value);

                return;

            case 'NULL':
                self::assertEquals(null, $value);

                return;
        }

        if (is_scalar($value)) {
            self::assertEquals($expectedType, gettype($value));

            return;
        }

        self::assertIsObject($value);
        self::assertInstanceOf($expectedType, $value);
    }

    private static function assertArrayIsList(mixed $value): void
    {
        self::assertIsArray($value);
        self::assertEquals(array_values($value), $value);
    }

    private static function assertArrayIsMap(mixed $value): void
    {
        self::assertIsArray($value);

        foreach (array_keys($value) as $key) {
            self::assertIsString($key);
        }
    }
}
