<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Model;

use Thormeier\TransportClientBundle\Model\Service;

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
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::multitypeProvider
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
     * @dataProvider Thormeier\TransportClientBundle\Tests\TestUtils\DataProvider\DataProvider::multitypeProvider
     */
    public function testIrregular($data)
    {
        $service = new Service;

        $service->setIrregular($data);
        $this->assertEquals($data, $service->getIrregular());
    }
}
