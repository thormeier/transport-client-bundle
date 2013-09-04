<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Model;

use Thormeier\TransportClientBundle\Model\Prognosis;

/**
 * Unit test for the prognosis entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class PrognosisTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getters and setters of platform
     *
     * @param unknown $data
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::multitypeProvider
     */
    public function testPlatform($data)
    {
        $prognosis = new Prognosis;

        $prognosis->setPlatform($data);
        $this->assertEquals($data, $prognosis->getPlatform());
    }

    /**
     * Test getters and setters of departure
     */
    public function testDeparture()
    {
        $tempDatetime = new \DateTime;
        $tempStdobj = new \stdClass;

        $prognosis = new Prognosis;

        $prognosis->setDeparture($tempDatetime);
        $this->assertInstanceOf('\DateTime', $prognosis->getDeparture());
        $this->assertEquals($tempDatetime, $prognosis->getDeparture());

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $prognosis->setDeparture($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $prognosis->setDeparture('foobar');
    }

    /**
     * Test getters and setters of arrival
     */
    public function testArrival()
    {
        $tempDatetime = new \DateTime;
        $tempStdobj = new \stdClass;

        $prognosis = new Prognosis;

        $prognosis->setArrival($tempDatetime);
        $this->assertInstanceOf('\DateTime', $prognosis->getArrival());
        $this->assertEquals($tempDatetime, $prognosis->getArrival());

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $prognosis->setArrival($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $prognosis->setArrival('foobar');
    }

    /**
     * Test getters and setters of capacity1st
     *
     * @param integer $capacity
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::numberProvider
     */
    public function testCapacity1st($capacity)
    {
        $prognosis = new Prognosis;

        $prognosis->setCapacity1st($capacity);
        $this->assertEquals($capacity, $prognosis->getCapacity1st());
    }

    /**
     * Test getters and setters of capacity2nd
     *
     * @param integer $capacity
     *
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::numberProvider
     */
    public function testCapacity2nd($capacity)
    {
        $prognosis = new Prognosis;

        $prognosis->setCapacity2nd($capacity);
        $this->assertEquals($capacity, $prognosis->getCapacity2nd());
    }
}
