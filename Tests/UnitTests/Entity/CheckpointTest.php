<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Model;

use Thormeier\TransportClientBundle\Model\Checkpoint;
use Thormeier\TransportClientBundle\Model\Location;
use Thormeier\TransportClientBundle\Model\Prognosis;

use Buzz\Browser;

/**
 * Unit test for the checkpoint entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class CheckpointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getter and setter of station
     */
    public function testStation()
    {
        $tempStation = new Location;
        $tempStdobj = new \stdClass;

        $checkpoint = new Checkpoint;

        $checkpoint->setStation($tempStation);

        $result = $checkpoint->getStation();
        $this->assertEquals($tempStation, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Location', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setStation($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setStation('foo');
    }

    /**
     * Test getter and setter of arrival
     */
    public function testArrival()
    {
        $tempArrival = new \DateTime;
        $tempStdobj = new \stdClass;

        $checkpoint = new Checkpoint;

        $checkpoint->setArrival($tempArrival);

        $result = $checkpoint->getArrival();
        $this->assertEquals($tempArrival, $result);
        $this->assertInstanceOf('\DateTime', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setArrival($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setArrival('foo');
    }

    /**
     * Test getter and setter of departure
     */
    public function testDeparture()
    {
        $tempDeparture = new \DateTime;
        $tempStdobj = new \stdClass;

        $checkpoint = new Checkpoint;

        $checkpoint->setDeparture($tempDeparture);

        $result = $checkpoint->getDeparture();
        $this->assertEquals($tempDeparture, $result);
        $this->assertInstanceOf('\DateTime', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setDeparture($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setDeparture('foo');
    }

    /**
     * Test getter and setter of delay
     *
     * @param unknown $delay
     *
     * @dataProvider integerProvider
     */
    public function testDelay($delay)
    {
        $checkpoint = new Checkpoint;

        $checkpoint->setDelay($delay);
        $this->assertEquals($checkpoint->getDelay(), $delay);
    }

    /**
     * Test getter and setter of platform
     *
     * @param unknown $platform
     *
     * @dataProvider platformProvider
     */
    public function testPlatform($platform)
    {
        $checkpoint = new Checkpoint;

        $checkpoint->setPlatform($platform);
        $this->assertEquals($checkpoint->getPlatform(), $platform);
    }

    /**
     * Test getter and setter of prognosis
     */
    public function testPrognosis()
    {
        $tempPrognosis = new Prognosis;
        $tempStdobj = new \stdClass;

        $checkpoint = new Checkpoint;

        $checkpoint->setPrognosis($tempPrognosis);

        $result = $checkpoint->getPrognosis();
        $this->assertEquals($tempPrognosis, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Prognosis', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setPrognosis($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $checkpoint->setPrognosis('foo');
    }

    /**
     * Data provider method for platforms
     *
     * @return array
     */
    public function platformProvider()
    {
        return array(
            array(1),
            array(2),
            array('foo'),
            array('bar'),
        );
    }

    /**
     * Data provider method for delay
     *
     * @return array
     */
    public function integerProvider()
    {
        return array(
            array(1),
            array(12),
            array(null),
        );
    }
}
