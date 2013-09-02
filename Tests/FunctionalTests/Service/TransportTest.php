<?php
namespace Thormeier\TransportClientBundle\Tests\FunctionalTests\Service;

use Thormeier\TransportClientBundle\Service\Transport;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional tests of the Transport class that actually calls
 * the API and tests if the returned results are legal entities
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
        try { // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $result = $this->transport->getLocations(array('query' => 'Lenzburg'));
        } catch (InvalidArgumentException $e) {
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
        try { // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $result = $this->transport->getLocations(array('query' => 'hausen'));
        } catch (InvalidArgumentException $e) {
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
        try { // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $result = $this->transport->getConnections(array('from' => 'Lenzburg', 'to' => 'Zürich'));
        } catch (InvalidArgumentException $e) {
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
        try { // See Thormeier\TransportClientBundle\Tests\FunctionalTests\TestUtils\Buzz\Client\FixtureClient
            $result = $this->transport->getStationboard(array('station' => 'Lenzburg'));
        } catch (InvalidArgumentException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertInternalType('array', $result);
        $this->assertContainsOnly('Thormeier\TransportClientBundle\Model\Stop', $result);
    }
}
