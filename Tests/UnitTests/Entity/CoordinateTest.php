<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Model;

use Thormeier\TransportClientBundle\Model\Coordinate;

/**
 * Unit test for the coordinate entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class CoordinateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getters and setters of x
     *
     * @param float $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::numberProvider
     */
    public function testX($data)
    {
        $coordinate = new Coordinate;

        $coordinate->setX($data);
        $this->assertEquals($data, $coordinate->getX());
    }

    /**
     * Test getters and setters of Y
     *
     * @param float $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::numberProvider
     */
    public function testY($data)
    {
        $coordinate = new Coordinate;

        $coordinate->setY($data);
        $this->assertEquals($data, $coordinate->getY());
    }

    /**
     * Test getters and setters of type
     *
     * @param string $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::stringProvider
     */
    public function testType($data)
    {
        $coordinate = new Coordinate;

        $coordinate->setType($data);
        $this->assertEquals($data, $coordinate->getType());
    }
}
