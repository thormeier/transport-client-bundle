<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Entity;

use Thormeier\TransportClientBundle\Entity\Location;
use Thormeier\TransportClientBundle\Entity\Coordinate;

/**
 * Unit test for the location entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class LocationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getters and setters of id
     *
     * @param unknown $data
     *
     * @dataProvider integerProvider
     */
    public function testId($data)
    {
        $location = new Location;

        $location->setId($data);
        $this->assertEquals($data, $location->getId());
    }

    /**
     * Test getters and setters of type
     *
     * @param unknown $data
     *
     * @dataProvider stringProvider
     */
    public function testType($data)
    {
        $location = new Location;

        $location->setType($data);
        $this->assertEquals($data, $location->getType());
    }

    /**
     * Test getters and setters of name
     *
     * @param unknown $data
     *
     * @dataProvider stringProvider
     */
    public function testName($data)
    {
        $location = new Location;

        $location->setName($data);
        $this->assertEquals($data, $location->getName());
    }

    /**
     * Test getters and setters of score
     *
     * @param unknown $data
     *
     * @dataProvider numberProvider
     */
    public function testScore($data)
    {
        $location = new Location;

        $location->setScore($data);
        $this->assertEquals($data, $location->getScore());
    }

    /**
     * Test getters and setters of distance
     *
     * @param unknown $data
     *
     * @dataProvider numberProvider
     */
    public function testDistance($data)
    {
        $location = new Location;

        $location->setDistance($data);
        $this->assertEquals($data, $location->getDistance());
    }

    /**
     * Test getters and setters of coordinate
     */
    public function testCoordinate()
    {
        $tempCoordinate = new Coordinate;
        $tempStdobj = new \stdClass;

        $location = new Location;

        $location->setCoordinate($tempCoordinate);
        $result = $location->getCoordinate();
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Coordinate', $result);
        $this->assertEquals($tempCoordinate, $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $location->setCoordinate($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $location->setCoordinate('foo');
    }

    /**
     * Data provider method for all integer methods
     *
     * @return array
     */
    public function integerProvider()
    {
        return array(
                    array(1),
                    array(123123),
                    array(-1),
                    array(null),
                );
    }

    /**
     * Data provider method for all string methods
     *
     * @return array
     */
    public function stringProvider()
    {
        return array(
                    array('foo'),
                    array(null),
                );
    }

    /**
     * Data provider method for all methods that are testing float/negative numbers
     *
     * @return array
     */
    public function numberProvider()
    {
        return array(
                    array(12),
                    array(-12),
                    array(12.34),
                    array(null),
                );
    }
}
