<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Service;

use Thormeier\TransportClientBundle\Service\Transport;

/**
 * Unit test for the service class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class TransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Transport
     */
    private $service;

    /**
     * Mocks all needed repositories and sets up an instance of the service class
     */
    public function setUp()
    {
        $connectionRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\ConnectionRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $locationRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\LocationRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $stopRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\StopRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->service = new Transport($connectionRepository, $locationRepository, $stopRepository);
    }

    /**
     * Test getting of API methods
     */
    public function testGetApiMethods()
    {
        $result = $this->service->getApiMethods();

        $this->assertInternalType('array', $result);
        $this->assertContainsOnly('string', $result);
    }

    /**
     * Test of exception throwing when an invalid API method is given
     */
    public function testValidateMethodNameException()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\UnknownApiMethodException');

        $this->service->get('foo', array());
    }
}
