<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Entity;

use Thormeier\TransportClientBundle\Entity\Service;

/**
 * Unit test for the service entity class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getters and setters of regular
     *
     * @param unknown $data
     *
     * @dataProvider dataProvider
     */
    public function testRegular($data)
    {
        $service = new Service;

        $service->setRegular($data);
        $this->assertEquals($data, $service->getRegular());
    }

    /**
     * Test getters and setters of irregular
     *
     * @param unknown $data
     *
     * @dataProvider dataProvider
     */
    public function testIrregular($data)
    {
        $service = new Service;

        $service->setIrregular($data);
        $this->assertEquals($data, $service->getIrregular());
    }

    /**
     * Data provider method for all test cases
     *
     * @return multitype:number string NULL
     */
    public function dataProvider()
    {
        return array(
                    array(1),
                    array('foo'),
                    array(null),
                );
    }
}
