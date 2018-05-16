<?php
declare(strict_types=1);

namespace Pwm\TC;

use PHPUnit\Framework\TestCase;
use Pwm\TC\Concrete\BoolCollection;
use Pwm\TC\Concrete\CallableCollection;
use Pwm\TC\Concrete\FloatCollection;
use Pwm\TC\Concrete\IntCollection;
use Pwm\TC\Concrete\StringCollection;
use Pwm\TC\TestCollection\Foobar;
use Pwm\TC\TestCollection\FoobarCollection;
use Pwm\TC\TestCollection\UntypedCollection;
use Throwable;
use TypeError;

final class TypedCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_typed_collections(): void
    {
        $typedCollectionMap = [
            BoolCollection::class     => [true, false, true],
            CallableCollection::class => [function ($a) { return $a; }, function ($b) { return $b; }],
            FloatCollection::class    => [1.0, 2.0, 3.0],
            FoobarCollection::class   => [new Foobar(1, 'a'), new Foobar(2, 'b'), new Foobar(3, 'c')],
            IntCollection::class      => [1, 2, 3],
            StringCollection::class   => ['a', 'b', 'c'],
        ];

        foreach ($typedCollectionMap as $type => $typedList) {
            self::assertInstanceOf(TypedCollection::class, new $type(...$typedList));
        }
    }

    /**
     * @test
     */
    public function it_throws_on_untyped_elements(): void
    {
        $untypedCollectionMap = [
            BoolCollection::class     => [true, false, 1],
            CallableCollection::class => [function ($a) { return $a; }, 4],
            FloatCollection::class    => [1.0, 2.0, 'a'],
            FoobarCollection::class   => [new Foobar(1, 'a'), new Foobar(2, 'b'), false],
            IntCollection::class      => [1, 2, 'a'],
            StringCollection::class   => ['a', 'b', 3],
        ];

        foreach ($untypedCollectionMap as $type => $untypedList) {
            try {
                new $type(...$untypedList);
                self::assertTrue(false); // should fail if we get here
            } catch (Throwable $e) {
                self::assertInstanceOf(TypeError::class, $e);
            }
        }
    }

    /**
     * @test
     * @expectedException \TypeError
     */
    public function it_throws_on_untyped_collection(): void
    {
        new UntypedCollection(1, 'a', false);
    }

    /**
     * @test
     */
    public function collections_are_iterable_countable_and_listable(): void
    {
        $collection = new IntCollection(1, 2, 3);

        // iterable
        foreach ($collection as $element) {
            self::assertInternalType('int', $element);
        }

        // countable
        self::assertCount(3, $collection);

        // listable
        self::assertSame([1, 2, 3], $collection->toList());
    }

    /**
     * @test
     */
    public function collections_can_be_empty(): void
    {
        $emptyList = [];

        $emptyCollectionMap = [
            BoolCollection::class     => $emptyList,
            CallableCollection::class => $emptyList,
            FloatCollection::class    => $emptyList,
            FoobarCollection::class   => $emptyList,
            IntCollection::class      => $emptyList,
            StringCollection::class   => $emptyList,
        ];

        foreach ($emptyCollectionMap as $type => $emptyList) {
            self::assertInstanceOf(TypedCollection::class, new $type(...$emptyList));
        }
    }

    /**
     * @test
     */
    public function null_is_never_typed(): void
    {
        $nullList = [null];

        $nullTypedCollectionMap = [
            BoolCollection::class     => $nullList,
            CallableCollection::class => $nullList,
            FloatCollection::class    => $nullList,
            FoobarCollection::class   => $nullList,
            IntCollection::class      => $nullList,
            StringCollection::class   => $nullList,
        ];

        foreach ($nullTypedCollectionMap as $type => $nullList) {
            try {
                new $type(...$nullList);
                self::assertTrue(false); // should fail if we get here
            } catch (Throwable $e) {
                self::assertInstanceOf(TypeError::class, $e);
            }
        }
    }
}
