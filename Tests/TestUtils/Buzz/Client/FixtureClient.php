<?php
namespace Thormeier\TransportClientBundle\Tests\TestUtils\Buzz\Client;

use Buzz\Exception\InvalidArgumentException;

use Buzz\Client\ClientInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

/**
 * Mocks the Transport API and returns fixtures for all API queries
 *
 * This is necessary to omit a dependency to an external service that might
 * be unreachable at any given time. This client
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class FixtureClient implements ClientInterface
{
    /**
     * Populates the supplied response with the response for the supplied request.
     *
     * @param RequestInterface $request  A request object
     * @param MessageInterface $response A response object
     */
    public function send(RequestInterface $request, MessageInterface $response)
    {
        $resource = $request->getResource();
        $queryParts = parse_url($resource);

        $fileName = $this->getFixtureFilename($queryParts['path'], $queryParts['query']);

        // If there are no fixtures to be loaded for this specific quey, let the test fail
        if (strlen($fileName) === 0) {
            throw new InvalidArgumentException(
                sprintf(
                    'No fixtures found for query "%s": Maybe you forgot to add a new fixture file after altering the tests or forgot to alter "%s"',
                    $resource,
                    __CLASS__
                )
            );
        }

        // Build full path of fixture file to be loaded
        $pathParts = array(
            dirname(__FILE__),
            '..',
            '..',
            'Fixtures',
            $fileName,
        );
        $path = implode(DIRECTORY_SEPARATOR, $pathParts);

        // If the file would be loaded but doesn't exist, let the test fail
        if (!file_exists($path)) {
            throw new InvalidArgumentException(
                'Fixture file "%s" was not found: Maybe you added a new fixture and forgot to add the file as well in "%s"',
                $path,
                __CLASS__
            );
        }

        $result = file_get_contents($path);

        $response->setContent($result);
    }

    /**
     * Necessary because Buzz\Browser says so.
     *
     * @return boolean
     */
    public function setTimeout()
    {
        return true;
    }

    /**
     * Determines the file name of the fixtures to be loaded according to
     * a given URL path and query string
     *
     * @param string $path
     * @param string $query
     *
     * @return string
     */
    private function getFixtureFilename($path, $query)
    {
        $fileName = '';

        // Determine file name of fixtures to be loaded
        if (strpos($path, 'locations') !== false) {

            if (strpos($query, 'Lenzburg') !== false) {
                // Thormeier\TransportClientBundle\Tests\FunctionalTests\Service\TransportTest::testGetSingleLocation
                $fileName = 'locations_lenzburg.json';
            } else {
                // Thormeier\TransportClientBundle\Tests\FunctionalTests\Service\TransportTest::testGetMultipleLocations
                $fileName = 'locations_hausen.json';
            }

        } elseif (strpos($path, 'connections') !== false) {
            // Thormeier\TransportClientBundle\Tests\FunctionalTests\Service\TransportTest::testGetConnections
            $fileName = 'connections_lenzburg_zurich.json';
        } elseif (strpos($path, 'stationboard') !== false) {
            // Thormeier\TransportClientBundle\Tests\FunctionalTests\Service\TransportTest::testGetStationBoard
            $fileName = 'stationboard_lenzburg.json';
        }

        return $fileName;
    }
}
