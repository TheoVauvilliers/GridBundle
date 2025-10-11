<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use TheoVauvilliers\GridBundle\Tests\Fixtures\Address;
use TheoVauvilliers\GridBundle\Tests\Fixtures\User;
use TheoVauvilliers\GridBundle\Transformer\DataAccessor;

/**
 * @covers \TheoVauvilliers\GridBundle\Transformer\DataAccessor
 */
final class DataAccessorTest extends TestCase
{
    private DataAccessor $accessor;

    protected function setUp(): void
    {
        $this->accessor = new DataAccessor();
    }

    public function testGetFromPureArray(): void
    {
        $data = ['a' => ['b' => 1]];

        self::assertSame(1, $this->accessor->get($data, 'a.b'));
        self::assertNull($this->accessor->get($data, 'a.c'));
    }

    public function testGetWithNumericIndexOnArray(): void
    {
        $data = ['items' => [['name' => 'x'], ['name' => 'y']]];

        self::assertSame('x', $this->accessor->get($data, 'items.0.name'));
        self::assertSame('y', $this->accessor->get($data, 'items.1.name'));
        self::assertNull($this->accessor->get($data, 'items.2.name'));
    }

    public function testGetFromArrayAccess(): void
    {
        $data = new \ArrayObject(['foo' => new \ArrayObject(['bar' => 42])]);

        self::assertSame(42, $this->accessor->get($data, 'foo.bar'));
        self::assertNull($this->accessor->get($data, 'foo.baz'));
    }

    public function testGetFromPureObject(): void
    {
        $user = new User('Alice', new Address('Paris'));

        self::assertSame('Alice', $this->accessor->get($user, 'name'));
        self::assertSame('Paris', $this->accessor->get($user, 'address.city'));
        self::assertNull($this->accessor->get($user, 'unknown'));
        self::assertNull($this->accessor->get($user, 'address.unknown'));
    }

    public function testGetMixedArrayToObject(): void
    {
        $user = new User('Bob', new Address('Lyon'));
        $data = ['user' => $user];

        self::assertSame('Bob', $this->accessor->get($data, 'user.name'));
        self::assertSame('Lyon', $this->accessor->get($data, 'user.address.city'));
    }

    public function testGetMixedObjectToArray(): void
    {
        $user = new User('Eve', new Address('Nice'), ['tags' => ['a', 'b']]);

        self::assertSame('a', $this->accessor->get($user, 'meta.tags.0'));
        self::assertSame('b', $this->accessor->get($user, 'meta.tags.1'));
        self::assertNull($this->accessor->get($user, 'meta.tags.2'));
    }

    public function testSetCreatesIntermediateArraysOnPureArray(): void
    {
        $data = [];
        $this->accessor->set($data, 'a.b.c', 123);

        self::assertSame(['a' => ['b' => ['c' => 123]]], $data);
        self::assertSame(123, $this->accessor->get($data, 'a.b.c'));
    }

    public function testSetOnArrayAccess(): void
    {
        $data = new \ArrayObject(['root' => new \ArrayObject()]);
        $this->accessor->set($data, 'root.key', 'val');

        self::assertSame('val', $this->accessor->get($data, 'root.key'));
    }

    public function testSetOnObjectWithSetter(): void
    {
        $user = new User('Alice', new Address('Paris'));
        $this->accessor->set($user, 'address.city', 'Rennes');

        self::assertSame('Rennes', $this->accessor->get($user, 'address.city'));
        self::assertSame('Rennes', $user->getAddress()->getCity());
    }

    public function testSetMixedObjectToArray(): void
    {
        $user = new User('Zoe', new Address('Nantes'), ['stats' => ['visits' => 1]]);

        $this->accessor->set($user, 'meta.stats.visits', 2);

        self::assertSame(2, $this->accessor->get($user, 'meta.stats.visits'));
        self::assertSame(2, $user->getMeta()['stats']['visits']);
    }

    public function testEmptyPathIsNoopForSetAndNullForGet(): void
    {
        $data = ['x' => 1];

        $this->accessor->set($data, '', 10);

        self::assertSame(['x' => 1], $data);
        self::assertNull($this->accessor->get($data, ''));
    }

    public function testDoubleDotSegmentsAreIgnored(): void
    {
        $data = ['a' => ['b' => 5]];

        self::assertSame(5, $this->accessor->get($data, 'a..b'));
    }
}
