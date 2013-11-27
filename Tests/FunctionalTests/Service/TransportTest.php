<?php
namespace Thormeier\TransportClientBundle\Tests\FunctionalTests\Service;

use Thormeier\TransportClientBundle\Service\Transport;
use Thormeier\TransportClientBundle\Tests\TestUtils\Buzz\Client\FixtureClient;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests of the Transport class that calls a mocked
 * API via a replaced Buzz Client, which returns a set of fixtures
 * in JSON format.
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class TransportTest extends WebTestCase
{
    /**
     * @var Transport
     */
    private $transport;

    /**
     * Set up a kernel and get the transport client service to test it
     *
     * This also tests the correct service definition
     */
    public function setUp()
    {
        static::createClient();

        $this->transport = static::$kernel->getContainer()->get('transport.client');
    }

    /**
     * Test getting of a single location
     */
    public function testGetSingleLocation()
    {
        try {
            $result = $this->transport->getLocations(array('query' => 'Lenzburg'));
        } catch (InvalidArgumentException $e) {
            // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $this->fail($e->getMessage());
        }

        $this->assertInternalType('array', $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Location', $result[0]);
    }

    /**
     * Test getting of multiple locations
     */
    public function testGetMultipleLocations()
    {
        try {
            $result = $this->transport->getLocations(array('query' => 'hausen'));
        } catch (InvalidArgumentException $e) {
            // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $this->fail($e->getMessage());
        }

        $this->assertInternalType('array', $result);
        $this->assertCount(50, $result);
        $this->assertContainsOnly('Thormeier\TransportClientBundle\Model\Location', $result);
    }

    /**
     * Test getting of connections
     */
    public function testGetConnections()
    {
        try {
            $result = $this->transport->getConnections(array('from' => 'Lenzburg', 'to' => 'Zürich'));
        } catch (InvalidArgumentException $e) {
            // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $this->fail($e->getMessage());
        }

        $this->assertInternalType('array', $result);
        $this->assertCount(4, $result);
        $this->assertContainsOnly('Thormeier\TransportClientBundle\Model\Connection', $result);
    }

    /**
     * Test getting of station board
     */
    public function testGetStationBoard()
    {
        try {
            $result = $this->transport->getStationboard(array('station' => 'Lenzburg'));
        } catch (InvalidArgumentException $e) {
            // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $this->fail($e->getMessage());
        }

        $this->assertInternalType('array', $result);
        $this->assertCount(40, $result);
        $this->assertContainsOnly('Thormeier\TransportClientBundle\Model\Stop', $result);
    }

    /**
     * Test throwing of exception
     */
    public function testGetApiException()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\ApiErrorException');

        $result = $this->transport->getStationboard(array('station' => FixtureClient::ERROR_TRIGGER_QUERY));
    }
}
