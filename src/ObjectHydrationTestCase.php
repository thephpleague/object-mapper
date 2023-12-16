<?php

declare(strict_types=1);

namespace League\ObjectMapper;

use League\ObjectMapper\Fixtures\CastersOnClasses\ClassWithClassLevelMapFrom;
use League\ObjectMapper\Fixtures\CastersOnClasses\ClassWithClassLevelMapFromMultiple;
use League\ObjectMapper\Fixtures\ClassThatCastsListsToDifferentTypes;
use League\ObjectMapper\Fixtures\ClassThatContainsAnotherClass;
use League\ObjectMapper\Fixtures\ClassThatHasMultipleCastersOnSingleProperty;
use League\ObjectMapper\Fixtures\ClassThatRenamesInputForClassWithMultipleProperties;
use League\ObjectMapper\Fixtures\ClassThatTriggersUseStatementLookup;
use League\ObjectMapper\Fixtures\ClassThatUsesClassWithMultipleProperties;
use League\ObjectMapper\Fixtures\ClassThatUsesMutipleCastersWithoutOptions;
use League\ObjectMapper\Fixtures\ClassWithCamelCaseProperty;
use League\ObjectMapper\Fixtures\ClassWithComplexTypeThatIsMapped;
use League\ObjectMapper\Fixtures\ClassWithDocblockAndArrayFollowingScalar;
use League\ObjectMapper\Fixtures\ClassWithDefaultValue;
use League\ObjectMapper\Fixtures\ClassWithDocblockArrayVariants;
use League\ObjectMapper\Fixtures\ClassWithFormattedDateTimeInput;
use League\ObjectMapper\Fixtures\ClassWithMappedStringProperty;
use League\ObjectMapper\Fixtures\ClassWithNotCastedDateTimeInput;
use League\ObjectMapper\Fixtures\ClassWithNullableInput;
use League\ObjectMapper\Fixtures\ClassWithNullableProperty;
use League\ObjectMapper\Fixtures\ClassWithPropertiesWithDefaultValues;
use League\ObjectMapper\Fixtures\ClassWithPropertyCasting;
use League\ObjectMapper\Fixtures\ClassWithPropertyMappedFromNestedKey;
use League\ObjectMapper\Fixtures\ClassWithPropertyThatUsesListCasting;
use League\ObjectMapper\Fixtures\ClassWithPropertyThatUsesListCastingToClasses;
use League\ObjectMapper\Fixtures\ClassWithStaticConstructor;
use League\ObjectMapper\Fixtures\ClassWithUnmappedStringProperty;
use League\ObjectMapper\Fixtures\ClassWithUuidProperty;
use League\ObjectMapper\Fixtures\TypeMapping\Animal;
use League\ObjectMapper\Fixtures\TypeMapping\ClassThatMapsTypes;
use League\ObjectMapper\Fixtures\TypeMapping\Frog;
use League\ObjectMapper\FixturesFor81\ClassWithEnumProperty;
use League\ObjectMapper\FixturesFor81\ClassWithEnumPropertyWithDefault;
use League\ObjectMapper\FixturesFor81\ClassWithNullableEnumProperty;
use League\ObjectMapper\FixturesFor81\ClassWithNullableUnitEnumProperty;
use League\ObjectMapper\FixturesFor81\CustomEnum;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class ObjectHydrationTestCase extends TestCase
{
    /**
     * @test
     */
    public function hydrating_a_polymorphic_property(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['child' => ['animal' => 'frog', 'color' => 'blue']];
        $object = $mapper->hydrateObject(ClassThatMapsTypes::class, $payload);

        self::assertInstanceOf(ClassThatMapsTypes::class, $object);
        self::assertInstanceOf(Frog::class, $object->child);
    }
    /**
     * @test
     */
    public function hydrating_a_polymorphic_interface(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['nested' => ['muppet' => 'kermit', 'color' => 'blue']];
        $object = $mapper->hydrateObject(Animal::class, $payload);

        self::assertInstanceOf(Animal::class, $object);
        self::assertInstanceOf(Frog::class, $object);
        self::assertEquals('blue', $object->color);
    }

    /**
     * @test
     */
    public function hydrating_with_class_level_map_from(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['nested' => ['name' => 'Frank']];
        $object = $mapper->hydrateObject(ClassWithClassLevelMapFrom::class, $payload);

        self::assertInstanceOf(ClassWithClassLevelMapFrom::class, $object);
        self::assertEquals('Frank', $object->name);
    }

    /**
     * @test
     */
    public function hydrating_with_class_level_map_from_with_multiple_sources(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['first' => 1, 'second' => 2];
        $object = $mapper->hydrateObject(ClassWithClassLevelMapFromMultiple::class, $payload);

        self::assertInstanceOf(ClassWithClassLevelMapFromMultiple::class, $object);
        self::assertEquals(1, $object->one);
        self::assertEquals(2, $object->two);
    }

    /**
     * @test
     */
    public function nullable_property_can_be_mapped_with_null_input(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithNullableInput::class, ['date' => null]);

        self::assertInstanceOf(ClassWithNullableInput::class, $object);
        self::assertNull($object->date);
    }

    /**
     * @test
     */
    public function class_with_parameter_with_default_value(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithDefaultValue::class, ['requiredValue' => 'supplied']);

        self::assertEquals('supplied', $object->requiredValue);
        self::assertEquals('default', $object->defaultValue);
    }

    /**
     * @test
     */
    public function nullable_property_can_be_mapped_with_real_input(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithNullableInput::class, ['date' => '2022-07-01']);

        self::assertInstanceOf(ClassWithNullableInput::class, $object);
        self::assertInstanceOf(\DateTimeImmutable::class, $object->date);
    }

    /**
     * @test
     */
    public function properties_can_be_mapped_from_a_specific_key(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithMappedStringProperty::class, ['my_name' => 'Frank']);

        self::assertInstanceOf(ClassWithMappedStringProperty::class, $object);
        self::assertEquals('Frank', $object->name);
    }

    /**
     * @test
     */
    public function mapping_a_nested_key(): void
    {
        $mapper = $this->createObjectMapper();

        /** @var ClassWithPropertyMappedFromNestedKey $object */
        $object = $mapper->hydrateObject(
            ClassWithPropertyMappedFromNestedKey::class,
            ['nested' => ['name' => 'Frank']]
        );

        self::assertInstanceOf(ClassWithPropertyMappedFromNestedKey::class, $object);
        self::assertEquals('Frank', $object->name);
    }

    /**
     * @test
     */
    public function trying_to_map_a_nested_key_from_shallow_input(): void
    {
        $mapper = $this->createObjectMapper();

        $this->expectExceptionObject(UnableToHydrateObject::dueToMissingFields(ClassWithPropertyMappedFromNestedKey::class, ['nested.name']));

        $mapper->hydrateObject(ClassWithPropertyMappedFromNestedKey::class, ['nested' => 'Frank']);
    }

    /**
     * @test
     */
    public function mapping_to_a_list_of_objects(): void
    {
        $mapper = $this->createObjectMapper();
        $input = [['my_name' => 'Frank'], ['my_name' => 'Renske']];

        $objects = $mapper->hydrateObjects(ClassWithMappedStringProperty::class, $input);

        self::assertContainsOnlyInstancesOf(ClassWithMappedStringProperty::class, $objects);
    }

    /**
     * @test
     */
    public function mapping_to_an_array_of_objects(): void
    {
        $mapper = $this->createObjectMapper();
        $input = [['my_name' => 'Frank'], ['my_name' => 'Renske']];

        $objects = $mapper->hydrateObjects(ClassWithMappedStringProperty::class, $input)->toArray();

        self::assertIsArray($objects);
        self::assertCount(2, $objects);
        self::assertContainsOnlyInstancesOf(ClassWithMappedStringProperty::class, $objects);
    }

    /**
     * @test
     */
    public function properties_are_mapped_by_name_by_default(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithUnmappedStringProperty::class, ['name' => 'Frank']);

        self::assertInstanceOf(ClassWithUnmappedStringProperty::class, $object);
        self::assertEquals('Frank', $object->name);
    }

    /**
     * @test
     */
    public function properties_can_be_cast_to_a_different_type(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithPropertyCasting::class, ['age' => '1234']);

        self::assertInstanceOf(ClassWithPropertyCasting::class, $object);
        self::assertEquals(1234, $object->age);
    }

    /**
     * @test
     */
    public function list_type_properties_can_be_cast_to_a_different_type(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithPropertyThatUsesListCasting::class, ['ages' => ['1234', '2345']]);

        self::assertInstanceOf(ClassWithPropertyThatUsesListCasting::class, $object);
        self::assertEquals([1234, 2345], $object->ages);
    }

    /**
     * @test
     */
    public function list_values_can_be_cast_to_objects(): void
    {
        $expectedChildren = [
            new ClassWithUnmappedStringProperty('Frank'),
            new ClassWithUnmappedStringProperty('Renske'),
        ];
        $mapper = $this->createObjectMapper();

        $payload = [
            'children' => [
                ['name' => 'Frank'],
                ['name' => 'Renske'],
            ],
        ];

        $object = $mapper->hydrateObject(ClassWithPropertyThatUsesListCastingToClasses::class, $payload);

        self::assertInstanceOf(ClassWithPropertyThatUsesListCastingToClasses::class, $object);
        self::assertEquals($expectedChildren, $object->children);
    }

    /**
     * @test
     */
    public function using_default_key_conversion_from_snake_case(): void
    {
        $mapper = $this->createObjectMapper(
            new DefinitionProvider(null, new KeyFormatterForSnakeCasing())
        );

        $object = $mapper->hydrateObject(ClassWithCamelCaseProperty::class, ['snake_case' => 'camelCase']);

        self::assertInstanceOf(ClassWithCamelCaseProperty::class, $object);
        self::assertEquals('camelCase', $object->snakeCase);
    }

    /**
     * @test
     */
    public function objects_can_have_static_constructors(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithStaticConstructor::class, ['name' => 'Renske']);

        self::assertInstanceOf(ClassWithStaticConstructor::class, $object);
        self::assertEquals('Renske', $object->name);
    }

    /**
     * @test
     */
    public function properties_are_mapped_automatically(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassThatContainsAnotherClass::class, ['child' => ['name' => 'Frank']]);

        self::assertInstanceOf(ClassThatContainsAnotherClass::class, $object);
        self::assertEquals('Frank', $object->child->name);
    }

    /**
     * @test
     */
    public function hydrating_a_complex_object_that_uses_property_casting(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithComplexTypeThatIsMapped::class, ['child' => 'de Jonge']);

        self::assertInstanceOf(ClassWithComplexTypeThatIsMapped::class, $object);
        self::assertEquals('de Jonge', $object->child->name);
    }

    /**
     * @test
     */
    public function hydrating_a_class_with_a_formatted_date(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithFormattedDateTimeInput::class, ['date' => '24-11-1987']);

        self::assertInstanceOf(ClassWithFormattedDateTimeInput::class, $object);
        self::assertEquals('1987-11-24 00:00:00', $object->date->format('Y-m-d H:i:s'));
        self::assertEquals('Europe/Amsterdam', $object->date->getTimezone()->getName());
    }

    /**
     * @test
     */
    public function hydrating_a_class_with_multiple_casters_without_options(): void
    {
        $mapper = $this->createObjectMapper();
        $payload = [
            'id' => '9f960d77-7c9b-4bfd-9fc4-62d141efc7e5',
            'name' => 'Joe',
        ];

        $object = $mapper->hydrateObject(ClassThatUsesMutipleCastersWithoutOptions::class, $payload);

        self::assertInstanceOf(ClassThatUsesMutipleCastersWithoutOptions::class, $object);
        self::assertEquals('9f960d77-7c9b-4bfd-9fc4-62d141efc7e5', $object->id->toString());
        self::assertEquals('joe', $object->name);
    }

    /**
     * @test
     */
    public function hydrating_a_class_with_a_not_casted_date_input(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithNotCastedDateTimeInput::class, ['date' => '2022-01-01 12:00:00']);

        self::assertInstanceOf(ClassWithNotCastedDateTimeInput::class, $object);
        self::assertEquals('2022-01-01 12:00:00', $object->date->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     */
    public function missing_properties_result_in_an_exception(): void
    {
        $mapper = $this->createObjectMapper();

        $this->expectExceptionObject(UnableToHydrateObject::dueToMissingFields(ClassWithUnmappedStringProperty::class, ['name']));

        $mapper->hydrateObject(ClassWithUnmappedStringProperty::class, []);
    }

    /**
     * @test
     * @requires PHP >= 8.1
     */
    public function hydrating_an_object_with_an_enum(): void
    {
        $mapper = $this->createObjectHydratorFor81();

        $object = $mapper->hydrateObject(ClassWithEnumProperty::class, ['enum' => 'one']);

        self::assertEquals(CustomEnum::VALUE_ONE, $object->enum);
    }

    /**
     * @test
     * @requires PHP >= 8.1
     */
    public function hydrating_an_object_with_a_nullable_enum(): void
    {
        $mapper = $this->createObjectHydratorFor81();

        $object = $mapper->hydrateObject(ClassWithNullableUnitEnumProperty::class, ['enum' => null]);

        self::assertNull($object->enum);
    }

    /**
     * @test
     * @requires PHP >= 8.1
     */
    public function hydrating_an_object_with_a_default_enum_value(): void
    {
        $mapper = $this->createObjectHydratorFor81();

        $object = $mapper->hydrateObject(ClassWithEnumPropertyWithDefault::class, []);

        self::assertEquals(CustomEnum::VALUE_ONE, $object->enum);
    }

    /**
     * @test
     * @requires PHP >= 8.1
     */
    public function hydrating_an_object_with_a_nullable_backed_enum(): void
    {
        $mapper = $this->createObjectHydratorFor81();

        $object = $mapper->hydrateObject(ClassWithNullableEnumProperty::class, [
            'enum' => null,
            'enumFromEmptyString' => '',
        ]);

        self::assertNull($object->enum);
        self::assertNull($object->enumFromEmptyString);
    }

    /**
     * @test
     */
    public function hydrating_classes_that_do_not_exist_cause_an_exception(): void
    {
        $mapper = $this->createObjectMapper();

        $this->expectException(UnableToHydrateObject::class);

        $mapper->hydrateObject('ThisClass\\DoesNotExist', []);
    }

    /**
     * @test
     */
    public function hydrating_a_class_with_a_nullable_property_defaults_to_null(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithNullableProperty::class, []);

        self::assertInstanceOf(ClassWithNullableProperty::class, $object);
        self::assertNull($object->defaultsToNull);
    }

    /**
     * @test
     */
    public function class_with_nullable_property_with_default_uses_default(): void
    {
        $mapper = $this->createObjectMapper();

        $object = $mapper->hydrateObject(ClassWithPropertiesWithDefaultValues::class, []);

        self::assertInstanceOf(ClassWithPropertiesWithDefaultValues::class, $object);
        self::assertEquals('default_used', $object->nullableWithDefaultString);
        self::assertEquals('default_string', $object->notNullableWithDefaultString);
    }

    /**
     * @test
     */
    public function missing_a_nested_field(): void
    {
        $mapper = $this->createObjectMapper();
        $payload = ['child' => []];

        $this->expectExceptionObject(UnableToHydrateObject::dueToError(
            ClassThatContainsAnotherClass::class,
            UnableToHydrateObject::dueToMissingFields(ClassWithUnmappedStringProperty::class, ['name'], ['child']),
        ));

        $mapper->hydrateObject(ClassThatContainsAnotherClass::class, $payload);
    }

    /**
     * @test
     */
    public function constructing_a_property_with_multiple_casters(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['child' => 12345];
        $object = $mapper->hydrateObject(ClassThatHasMultipleCastersOnSingleProperty::class, $payload);

        self::assertInstanceOf(ClassThatHasMultipleCastersOnSingleProperty::class, $object);
        self::assertEquals('12345', $object->child->name);
    }

    /**
     * @test
     */
    public function mapping_multiple_keys_to_one_object(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['value' => 'dog', 'name' => 'Rover', 'age' => 2];
        $object = $mapper->hydrateObject(ClassThatUsesClassWithMultipleProperties::class, $payload);

        self::assertInstanceOf(ClassThatUsesClassWithMultipleProperties::class, $object);
        self::assertEquals('dog', $object->value);
        self::assertEquals('Rover', $object->child->name);
        self::assertEquals(2, $object->child->age);
    }

    /**
     * @test
     */
    public function casting_a_property_to_a_uuid(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['id' => '9f960d77-7c9b-4bfd-9fc4-62d141efc7e5'];
        $object = $mapper->hydrateObject(ClassWithUuidProperty::class, $payload);

        self::assertInstanceOf(ClassWithUuidProperty::class, $object);
        self::assertInstanceOf(UuidInterface::class, $object->id);
        self::assertTrue($object->id->equals(Uuid::fromString('9f960d77-7c9b-4bfd-9fc4-62d141efc7e5')));
    }

    /**
     * @test
     */
    public function mapping_multiple_keys_to_one_object_with_renames(): void
    {
        $mapper = $this->createObjectMapper();

        $payload = ['name' => 'Rover', 'mapped_age' => 2];
        $object = $mapper->hydrateObject(ClassThatRenamesInputForClassWithMultipleProperties::class, $payload);

        self::assertInstanceOf(ClassThatRenamesInputForClassWithMultipleProperties::class, $object);
        self::assertEquals('Rover', $object->child->name);
        self::assertEquals(2, $object->child->age);
    }

    /**
     * @test
     */
    public function using_the_same_hydrator_with_different_options(): void
    {
        $mapper = $this->createObjectMapper();
        $payload = [
            'first' => [
                ['snakeCase' => 'first'],
            ],
            'second' => [
                ['age' => '34'],
            ],
        ];

        $object = $mapper->hydrateObject(ClassThatCastsListsToDifferentTypes::class, $payload);

        self::assertInstanceOf(ClassThatCastsListsToDifferentTypes::class, $object);
        self::assertContainsOnlyInstancesOf(ClassWithCamelCaseProperty::class, $object->first);
        self::assertContainsOnlyInstancesOf(ClassWithPropertyCasting::class, $object->second);
    }

    /**
     * @test
     */
    public function hydrating_a_class_with_use_function_statement(): void
    {
        $mapper = $this->createObjectMapper();
        $payload = [
            'firstName' => 'Jane',
            'lastName' => 'Doe',
        ];

        $object = $mapper->hydrateObject(ClassThatTriggersUseStatementLookup::class, $payload);

        self::assertInstanceOf(ClassThatTriggersUseStatementLookup::class, $object);
    }

    /**
     * @test
     */
    public function hydrating_a_class_with_valid_docblock_array_following_scalar(): void {
        $mapper = $this->createObjectMapper();
        $payload = [
            'test' => 'Brad',
            'test2' => ['Gianna', 'Kate'],
        ];

        $object = $mapper->hydrateObject(ClassWithDocblockAndArrayFollowingScalar::class, $payload);

        self::assertInstanceOf(ClassWithDocblockAndArrayFollowingScalar::class, $object);
    }

    /**
     * @test
     * @see https://github.com/LeaguePHP/ObjectHydrator/issues/56
     */
    public function hydrating_a_class_with_valid_docblock_array_different_formats(): void {
        $mapper = $this->createObjectMapper();
        $payload = [
            'test' => ['Brad', 'Jones'],
            'test2' => ['Buffy', 'Witt'],
            'test3' => ['Flying', 'Spaghetti', 'Monster'],
            'test4' => ['One' => 1, 'Two' => 2],
            'test5' => [0 => 'Zero', 'One' => 'One'],
            'test6' => [['defaultsToNull' => 'Array member that is cast to an object.']],
            'test7' => [[]],
            'test8' => [[]],
            'test9' => [[]],
            'test10' => [[]],
        ];

        $object = $mapper->hydrateObject(ClassWithDocblockArrayVariants::class, $payload);

        foreach (['test6', 'test7', 'test8', 'test9', 'test10'] as $property) {
            self::assertContainsOnlyInstancesOf(ClassWithNullableProperty::class, $object->{$property});
        }
        self::assertInstanceOf(ClassWithDocblockArrayVariants::class, $object);
    }

    protected function createObjectHydratorFor81(): ObjectMapper
    {
        return $this->createObjectMapper();
    }

    abstract protected function createObjectMapper(DefinitionProvider $definitionProvider = null): ObjectMapper;
}
