<?php
declare(strict_types=1);

namespace Pwm\TC;

use PHPUnit\Framework\TestCase;
use Pwm\TC\TestCollections\ArrayCollection;
use Pwm\TC\TestCollections\BoolCollection;
use Pwm\TC\TestCollections\CallableCollection;
use Pwm\TC\TestCollections\FloatCollection;
use Pwm\TC\TestCollections\Foobar;
use Pwm\TC\TestCollections\FoobarCollection;
use Pwm\TC\TestCollections\IntCollection;
use Pwm\TC\TestCollections\StringCollection;
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
            ArrayCollection::class    => [[], [], []],
            BoolCollection::class     => [true, false, true],
            CallableCollection::class => [function ($a) { return $a; }, function ($b) { return $b; }],
            FloatCollection::class    => [1.0, 2.0, 3.0],
            FoobarCollection::class   => [new Foobar(1, 'a'), new Foobar(2, 'b'), new Foobar(3, 'c')],
            IntCollection::class      => [1, 2, 3],
            StringCollection::class   => ['a', 'b', 'c'],
        ];

        foreach ($typedCollectionMap as $type => $typedList) {
            self::assertInstanceOf(TypedCollection::class, new $type($typedList));
        }
    }

    /**
     * @test
     */
    public function it_throws_on_untyped_collections(): void
    {
        $untypedCollectionMap = [
            ArrayCollection::class    => [[], [], 'a'],
            BoolCollection::class     => [true, false, 1],
            CallableCollection::class => [function ($a) { return $a; }, 4],
            FloatCollection::class    => [1.0, 2.0, 'a'],
            FoobarCollection::class   => [new Foobar(1, 'a'), new Foobar(2, 'b'), false],
            IntCollection::class      => [1, 2, 'a'],
            StringCollection::class   => ['a', 'b', 3],
        ];

        foreach ($untypedCollectionMap as $type => $untypedList) {
            try {
                new $type($untypedList);
                self::assertTrue(false); // should fail if we get here
            } catch (Throwable $e) {
                self::assertInstanceOf(TypeError::class, $e);
            }
        }
    }

    /**
     * @test
     */
    public function collections_are_iterable_countable_and_listable(): void
    {
        $list = [1, 2, 3];

        $collection = new IntCollection($list);

        // iterable
        foreach ($collection as $element) {
            self::assertInternalType('int', $element);
        }

        // countable
        self::assertCount(3, $collection);

        // listable
        self::assertSame($list, $collection->toList());
    }

    /**
     * @test
     */
    public function collections_can_be_empty(): void
    {
        self::assertInstanceOf(ArrayCollection::class, new ArrayCollection([]));
        self::assertInstanceOf(BoolCollection::class, new BoolCollection([]));
        self::assertInstanceOf(CallableCollection::class, new CallableCollection([]));
        self::assertInstanceOf(FloatCollection::class, new FloatCollection([]));
        self::assertInstanceOf(FoobarCollection::class, new FoobarCollection([]));
        self::assertInstanceOf(IntCollection::class, new IntCollection([]));
        self::assertInstanceOf(StringCollection::class, new StringCollection([]));
    }

    /**
     * @test
     */
    public function null_is_never_typed(): void
    {
        $nullTypedCollectionMap = [
            ArrayCollection::class    => [null],
            BoolCollection::class     => [null],
            CallableCollection::class => [null],
            FloatCollection::class    => [null],
            FoobarCollection::class   => [null],
            IntCollection::class      => [null],
            StringCollection::class   => [null],
        ];

        foreach ($nullTypedCollectionMap as $type => $nullList) {
            try {
                new $type($nullList);
                self::assertTrue(false); // should fail if we get here
            } catch (Throwable $e) {
                self::assertInstanceOf(TypeError::class, $e);
            }
        }
    }
}
