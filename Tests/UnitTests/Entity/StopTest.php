<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Model;

use Thormeier\TransportClientBundle\Model\Stop;
use Thormeier\TransportClientBundle\Model\Location;

/**
 * Unit test for the stop entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class StopTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getters and setter of station
     */
    public function testStation()
    {
        $tempLocation = new Location;
        $tempStdobj = new \stdClass;

        $stop = new Stop;

        $stop->setStation($tempLocation);

        $result = $stop->getStation();
        $this->assertEquals($tempLocation, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Location', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $stop->setStation($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $stop->setStation('foo');
    }

    /**
     * Test getters and setters of name
     *
     * @param unknown $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::stringProvider
     */
    public function testName($data)
    {
        $stop = new Stop;

        $stop->setName($data);
        $this->assertEquals($data, $stop->getName());
    }

    /**
     * Test getters and setters of to
     */
    public function testTo()
    {
        $tempLocation = new Location;
        $tempStdobj = new \stdClass;

        $stop = new Stop;

        $stop->setTo($tempLocation);

        $result = $stop->getTo();
        $this->assertEquals($tempLocation, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Location', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $stop->setTo($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $stop->setTo('foo');
    }

    /**
     * Test getters and setters of category
     *
     * @param unknown $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::stringProvider
     */
    public function testCategory($data)
    {
        $stop = new Stop;

        $stop->setCategory($data);
        $this->assertEquals($data, $stop->getCategory());
    }

    /**
     * Test getters and setters of number
     *
     * @param unknown $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::numberProvider
     */
    public function testNumber($data)
    {
        $stop = new Stop;

        $stop->setNumber($data);
        $this->assertEquals($data, $stop->getNumber());
    }

    /**
     * Test getters and setters of operator
     *
     * @param unknown $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::stringProvider
     */
    public function testOperator($data)
    {
        $stop = new Stop;

        $stop->setOperator($data);
        $this->assertEquals($data, $stop->getOperator());
    }
}
