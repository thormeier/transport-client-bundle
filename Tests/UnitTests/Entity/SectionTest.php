<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Model;

use Thormeier\TransportClientBundle\Model\Checkpoint;
use Thormeier\TransportClientBundle\Model\Section;
use Thormeier\TransportClientBundle\Model\Journey;

/**
 * Unit test for the section entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class SectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getter and setter of journey
     */
    public function testJourney()
    {
        $tempJourney = new Journey;
        $tempStdobj = new \stdClass;

        $section = new Section;

        $section->setJourney($tempJourney);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Journey', $section->getJourney());
        $this->assertEquals($tempJourney, $section->getJourney());


        $this->setExpectedException('\PHPUnit_Framework_Error');
        $section->setJourney($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $section->setJourney('foo');
    }

    /**
     * Test getter and setter of walk
     *
     * @param unknown $data
     *
     * @dataProvider walkProvider
     */
    public function testWalk($data)
    {
        $section = new Section;

        $section->setWalk($data);
        $this->assertEquals($data, $section->getWalk());
    }

    /**
     * Test getter and setter of departure
     */
    public function testDeparture()
    {
        $tempCheckpoint = new Checkpoint;
        $tempStdobj = new \stdClass;

        $section = new Section;

        $section->setDeparture($tempCheckpoint);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $section->getDeparture());
        $this->assertEquals($tempCheckpoint, $section->getDeparture());


        $this->setExpectedException('\PHPUnit_Framework_Error');
        $section->setDeparture($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $section->setDeparture('foo');
    }

    /**
     * Test getter and setter of departure
     */
    public function testArrival()
    {
        $tempCheckpoint = new Checkpoint;
        $tempStdobj = new \stdClass;

        $section = new Section;

        $section->setArrival($tempCheckpoint);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $section->getArrival());
        $this->assertEquals($tempCheckpoint, $section->getArrival());


        $this->setExpectedException('\PHPUnit_Framework_Error');
        $section->setArrival($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $section->setArrival('foo');
    }

    /**
     * Data provier method for walk test
     *
     * @return array
     */
    public function walkProvider()
    {
        return array(
                    array(1),
                    array(-1),
                    array(null),
                );
    }
}
