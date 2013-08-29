<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Entity;

use Thormeier\TransportClientBundle\Entity\Checkpoint;
use Thormeier\TransportClientBundle\Entity\Journey;
use Thormeier\TransportClientBundle\Entity\Location;

/**
 * Unit test for the journey entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class JourneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getter and setter of name
     *
     * @param unknown $data
     *
     * @dataProvider stringProvider
     */
    public function testName($data)
    {
        $journey = new Journey;
        $journey->setName($data);

        $this->assertEquals($journey->getName(), $data);
    }

    /**
     * Test getter and setter of category
     *
     * @param unknown $data
     *
     * @dataProvider stringProvider
     */
    public function testCategory($data)
    {
        $journey = new Journey;
        $journey->setCategory($data);

        $this->assertEquals($journey->getCategory(), $data);
    }

    /**
     * Test getter and setter of number
     *
     * @param unknown $data
     *
     * @dataProvider numberProvider
     */
    public function testNumber($data)
    {
        $journey = new Journey;
        $journey->setNumber($data);

        $this->assertEquals($journey->getNumber(), $data);
    }

    /**
     * Test getter and setter of operator
     *
     * @param unknown $data
     *
     * @dataProvider stringProvider
     */
    public function testOperator($data)
    {
        $journey = new Journey;
        $journey->setOperator($data);

        $this->assertEquals($journey->getOperator(), $data);
    }

    /**
     * Test getter and setter of "to"
     */
    public function testTo()
    {
        $location = new Location;
        $stdObj = new \stdClass;

        $journey = new Journey;

        $journey->setTo($location);
        $this->assertEquals($journey->getTo(), $location);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Location', $journey->getTo());

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $journey->setTo($stdObj);

        $this->setExpectedException('\PHPUnit_Framework_Error');
        $journey->setTo('foo');
    }

    /**
     * Test getter and setter of passList
     */
    public function testPassList()
    {
        $pass1 = new Checkpoint;
        $pass1->setDelay(1);
        $pass2 = new Checkpoint;
        $pass2->setDelay(2);
        $pass3 = new Checkpoint;
        $pass3->setDelay(3);

        $testArray1 = new \ArrayObject(array($pass1, $pass2));
        $testArray2 = new \ArrayObject(array($pass2));
        $testArray3 = new \ArrayObject(array($pass2, $pass3));

        $journey = new Journey;

        $journey->addPass($pass1);
        $journey->addPass($pass2);

        $this->assertEquals($testArray1, $journey->getPassList());

        $journey->removePass($pass1);

        $this->assertEquals($testArray2, $journey->getPassList());

        $journey->addPass($pass3);

        $this->assertEquals($testArray3, $journey->getPassList());
    }

    /**
     * Test getters and setters of capacity1st
     *
     * @param integer $capacity
     *
     * @dataProvider numberProvider
     */
    public function testCapacity1st($capacity)
    {
        $journey = new Journey;

        $journey->setCapacity1st($capacity);
        $this->assertEquals($capacity, $journey->getCapacity1st());
    }

    /**
     * Test getters and setters of capacity2nd
     *
     * @param integer $capacity
     *
     * @dataProvider numberProvider
     */
    public function testCapacity2nd($capacity)
    {
        $journey = new Journey;

        $journey->setCapacity2nd($capacity);
        $this->assertEquals($capacity, $journey->getCapacity2nd());
    }

    /**
     * Data provider method for string method tests
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
     * Data provider method for number method tests
     *
     * @return array
     */
    public function numberProvider()
    {
        return array(
                array(12),
                array(-12),
                array(null),
        );
    }
}
