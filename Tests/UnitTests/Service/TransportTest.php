<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Service;

use Thormeier\TransportClientBundle\Service\Transport;
use Thormeier\TransportClientBundle\Repository\CoordinateRepository;

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
        // Mock repistories that are injected into the service class
        $connectionRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\ConnectionRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $locationRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\LocationRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $stopRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\StopRepository')
            ->disableOriginalConstructor()
            ->getMock();

        // Set up service class
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

    /**
     * Test throwing of exception on invalid repository by mocking a single method
     */
    public function testInvalidRepository()
    {
        // Mock a single method of the service to test another one
        $service = $this->getMockBuilder('Thormeier\TransportClientBundle\Service\Transport')
            ->setMethods(array('getRepositoryByApiMethod'))
            ->disableOriginalConstructor()
            ->getMock();

        // Return a repository that does not implement the ApiAwareRepository
        $service->expects($this->any())
            ->method('getRepositoryByApiMethod')
            ->will($this->returnValue(new CoordinateRepository()));

        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\RepositoryNotFoundException');

        $service->get(Transport::CONNECTION, array());
    }

    /**
     * Test throwing of exception on non-existant repository by mocking a single method
     */
    public function testNonpresentRepository()
    {
        $nonexistantMethod = 'foo';

        // Mock a single method of the service to test another one
        $service = $this->getMockBuilder('Thormeier\TransportClientBundle\Service\Transport')
            ->setMethods(array('getApiMethods'))
            ->disableOriginalConstructor()
            ->getMock();

        $service->expects($this->any())
            ->method('getApiMethods')
            ->will($this->returnValue(array($nonexistantMethod)));

        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\RepositoryNotFoundException');

        $service->get($nonexistantMethod, array());
    }
}
