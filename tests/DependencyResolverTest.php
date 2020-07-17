<?php
namespace Algorithm\Tests;

use Algorithm\DependencyResolver;

class DependencyResolverTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @expectedException \Algorithm\CircularReferenceException
     * @expectedExceptionMessage Circular dependency: C -> A
     */
    public function testCircleDependenciesCase1()
    {
        $tree  = array(
            'A' => array('B'),
            'B' => array('C'),
            'C' => array('A'),
        );
        DependencyResolver::resolve($tree);
    }

    /**
     * @expectedException \Algorithm\CircularReferenceException
     * @expectedExceptionMessage Circular dependency: B -> A
     */
    public function testCircleDependenciesCase2()
    {
        $tree  = array(
            'A' => array('E'),
            'B' => array('A'),
            'C' => array('B'),
            'D' => array('C', 'A'),
            'E' => array('C', 'B'),
        );
        DependencyResolver::resolve($tree);
    }

    public function testResolverCase1()
    {
        $tree  = array(
            'A' => array('B'),
            'B' => array('C'),
            'C' => array(),
        );
        $resolution = DependencyResolver::resolve($tree);
        $this->assertEquals($resolution, array('C','B','A'));
    }

    public function testResolverCase2()
    {
        $tree  = array(
            'A' => array('C'),
            'B' => array('C'),
            'C' => array(),
            'D' => array('B'),
        );
        $resolution = DependencyResolver::resolve($tree);
        $this->assertEquals($resolution, array('C','A','B','D'));
    }

    public function testResolverCase3()
    {
        $tree  = array(
            'A' => array(),
            'B' => array('A'),
            'C' => array('B'),
            'D' => array('C', 'A'),
            'E' => array('C', 'B'),
        );
        $resolution = DependencyResolver::resolve($tree);
        $this->assertEquals($resolution, array('A','B','C','D','E'));
    }

    public function testResolverCase4()
    {
        $tree  = array(
            'A' => array(),
            'B' => array('A'),
            'D' => array('C', 'A'),
            'C' => array('B'),
            'E' => array('C', 'B'),
        );
        $resolution = DependencyResolver::resolve($tree);
        $this->assertEquals($resolution, array('A','B','C','D','E'));
    }
}
