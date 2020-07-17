<?php declare(strict_types=1);

namespace Algorithm\Tests;

use Algorithm\DependencyResolver;
use Algorithm\Exception\CircularReferenceException;
use Algorithm\Exception\MissingReferenceException;
use Algorithm\ResolveBehaviour;
use PHPUnit\Framework\TestCase;

class DependencyResolverTest extends TestCase
{
    public function testCircleDependenciesCase1(): void
    {
        $this->expectException(CircularReferenceException::class);
        $this->expectExceptionMessage('Circular dependency: C -> A');

        $tree = [
            'A' => ['B'],
            'B' => ['C'],
            'C' => ['A'],
        ];
        DependencyResolver::resolve($tree);
    }

    public function testCircleDependenciesCaseThrowBehaviour(): void
    {
        $this->expectException(CircularReferenceException::class);
        $this->expectExceptionMessage('Circular dependency: B -> A');

        $tree = [
            'A' => ['B'],
            'B' => ['A'],
        ];
        DependencyResolver::resolve(
            $tree,
            ResolveBehaviour::create()->setThrowOnCircularReference(true)
        );
    }

    public function testCircleDependenciesCaseNotThrowBehaviour(): void
    {
        $tree = [
            'A' => ['B'],
            'B' => ['A'],
        ];
        $resolution = DependencyResolver::resolve(
            $tree,
            ResolveBehaviour::create()->setThrowOnCircularReference(false)
        );
        static::assertEquals($resolution, []);
    }

    public function testCircleDependenciesCase2(): void
    {
        $this->expectException(CircularReferenceException::class);
        $this->expectExceptionMessage('Circular dependency: B -> A');

        $tree = [
            'A' => ['E'],
            'B' => ['A'],
            'C' => ['B'],
            'D' => ['C', 'A'],
            'E' => ['C', 'B'],
        ];
        DependencyResolver::resolve($tree);
    }

    public function testResolverCase1(): void
    {
        $tree = [
            'A' => ['B'],
            'B' => ['C'],
            'C' => [],
        ];
        $resolution = DependencyResolver::resolve($tree);
        static::assertEquals($resolution, ['C','B','A']);
    }

    public function testResolverCase2(): void
    {
        $tree = array(
            'A' => array('C'),
            'B' => array('C'),
            'C' => array(),
            'D' => array('B'),
        );
        $resolution = DependencyResolver::resolve($tree);
        static::assertEquals($resolution, ['C','A','B','D']);
    }

    public function testResolverCase3(): void
    {
        $tree = [
            'A' => [],
            'B' => ['A'],
            'C' => ['B'],
            'D' => ['C', 'A'],
            'E' => ['C', 'B'],
        ];
        $resolution = DependencyResolver::resolve($tree);
        static::assertEquals($resolution, ['A','B','C','D','E']);
    }

    public function testResolverCase4(): void
    {
        $tree = [
            'A' => [],
            'B' => ['A'],
            'D' => ['C', 'A'],
            'C' => ['B'],
            'E' => ['C', 'B'],
        ];
        $resolution = DependencyResolver::resolve($tree);
        static::assertEquals($resolution, ['A','B','C','D','E']);
    }

    public function testMissingDependenciesCaseThrowBehaviour(): void
    {
        $this->expectException(MissingReferenceException::class);
        $this->expectExceptionMessage('Missing dependency: B -> A');

        $tree = [
            'B' => ['A'],
        ];
        DependencyResolver::resolve(
            $tree,
            ResolveBehaviour::create()->setThrowOnMissingReference(true)
        );
    }

    public function testMissingDependenciesCaseNotThrowBehaviour(): void
    {
        $tree = [
            'B' => ['A'],
        ];
        $resolution = DependencyResolver::resolve(
            $tree,
            ResolveBehaviour::create()->setThrowOnMissingReference(false)
        );
        static::assertEquals($resolution, []);
    }
}
