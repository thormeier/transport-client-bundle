<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Model;

use Thormeier\TransportClientBundle\Model\Connection;
use Thormeier\TransportClientBundle\Model\Checkpoint;
use Thormeier\TransportClientBundle\Model\Section;
use Thormeier\TransportClientBundle\Model\Service;

/**
 * Unit test for the connection entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getters and setter of from
     */
    public function testFrom()
    {
        $tempCheckpoint = new Checkpoint;
        $tempStdobj = new \stdClass;

        $connection = new Connection;

        $connection->setFrom($tempCheckpoint);

        $result = $connection->getFrom();
        $this->assertEquals($tempCheckpoint, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setFrom($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setFrom('foo');
    }

    /**
     * Test getters and setters of to
     */
    public function testTo()
    {
        $tempCheckpoint = new Checkpoint;
        $tempStdobj = new \stdClass;

        $connection = new Connection;

        $connection->setTo($tempCheckpoint);

        $result = $connection->getTo();
        $this->assertEquals($tempCheckpoint, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setTo($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setTo('foo');
    }

    /**
     * Test getters and setters of duration
     */
    public function testDuration()
    {
        $tempDuration = new \DateInterval('P1D');
        $tempStdobj = new \stdClass;

        $connection = new Connection;

        $connection->setDuration($tempDuration);

        $result = $connection->getDuration();
        $this->assertEquals($tempDuration, $result);
        $this->assertInstanceOf('DateInterval', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setDuration($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setDuration('foo');
    }

    /**
     * Test getters and setters of service
     */
    public function testService()
    {
        $tempService = new Service;
        $tempStdobj = new \stdClass;

        $connection = new Connection;

        $connection->setService($tempService);

        $result = $connection->getService();
        $this->assertEquals($tempService, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Service', $result);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setService($tempStdobj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $connection->setService('foo');
    }

    /**
     * Test getters and setters of product
     */
    public function testProduct()
    {
        $connection = new Connection;
        $testArrayObject1 = new \ArrayObject(array(1, 2));
        $testArrayObject2 = new \ArrayObject(array(1));
        $testArrayObject3 = new \ArrayObject(array(1, 3));

        $connection->addProduct(1);
        $connection->addProduct(2);

        $this->assertEquals($testArrayObject1, $connection->getProduct());

        $connection->removeProduct(2);

        $this->assertEquals($testArrayObject2, $connection->getProduct());

        $connection->addProduct(3);

        $this->assertEquals($testArrayObject3, $connection->getProduct());
    }

    /**
     * Test getters and setters of section
     */
    public function testSection()
    {
        $connection = new Connection;

        $section1 = new Section;
        $section1->setWalk(1);
        $section2 = new Section;
        $section2->setWalk(2);
        $section3 = new Section;
        $section3->setWalk(3);

        $testArrayObject1 = new \ArrayObject(array($section1, $section2));
        $testArrayObject2 = new \ArrayObject(array($section2));
        $testArrayObject3 = new \ArrayObject(array($section2, $section3));

        $connection->addSection($section1);
        $connection->addSection($section2);

        $this->assertEquals($testArrayObject1, $connection->getSection());

        $connection->removeSection($section1);

        $this->assertEquals($testArrayObject2, $connection->getSection());

        $connection->addSection($section3);

        $this->assertEquals($testArrayObject3, $connection->getSection());
    }


    /**
     * Test getters and setters of capacity1st
     *
     * @param integer $capacity
     *
     * @dataProvider capacityProvider
     */
    public function testCapacity1st($capacity)
    {
        $connection = new Connection;

        $connection->setCapacity1st($capacity);
        $this->assertEquals($capacity, $connection->getCapacity1st());
    }

    /**
     * Test getters and setters of capacity2nd
     *
     * @param integer $capacity
     *
     * @dataProvider capacityProvider
     */
    public function testCapacity2nd($capacity)
    {
        $connection = new Connection;

        $connection->setCapacity2nd($capacity);
        $this->assertEquals($capacity, $connection->getCapacity2nd());
    }

    /**
     * Data provider method for both capacity tests
     *
     * @return array
     */
    public function capacityProvider()
    {
        return array(
                    array(1),
                    array(2),
                    array(-1),
                );
    }
}

