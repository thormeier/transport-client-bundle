<?php
namespace Thormeier\TransportClientBundle\Service;

use Thormeier\TransportClientBundle\Repository\ConnectionRepository;
use Thormeier\TransportClientBundle\Repository\LocationRepository;
use Thormeier\TransportClientBundle\Repository\StopRepository;

use Thormeier\TransportClientBundle\Repository\ApiAwareRepository;
use Thormeier\TransportClientBundle\Exception\UnknownApiMethodException;
use Thormeier\TransportClientBundle\Exception\RepositoryNotFoundException;

/**
 * Transport API Client Service class
 *
 * This service class provides functionality to query
 * the Transport API by OpenData via a number of
 * repositories that generate instances of entity
 * classes.
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Transport implements TransportInterface
{
    /**
     * Constant used for determination of correct repository
     *
     * @var string
     */
    const LOCATION = 'location';

    /**
     * Constant used for determination of correct repository
     *
     * @var string
     */
    const CONNECTION = 'connection';

    /**
     * Constant used for determination of correct repository
     *
     * @var string
     */
    const STOP = 'stop';

    /**
     * @var ConnectionRepository
     */
    private $connectionRepository;

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var StopRepository
     */
    private $stopRepository;

    /**
     * Array of callable API methods
     *
     * @var array
     */
    private $apiMethods = array(
                self::CONNECTION => ConnectionRepository::API_METHOD_NAME,
                self::LOCATION => LocationRepository::API_METHOD_NAME,
                self::STOP => StopRepository::API_METHOD_NAME,
            );

    /**
     * Transport client bundle service class
     *
     * Allows access to the TransportAPI provided by OpenData via the given repositories
     *
     * @param ConnectionRepository $connectionRepository
     * @param LocationRepository   $locationRepository
     * @param StopRepository       $stopRepository
     */
    public function __construct(
            ConnectionRepository $connectionRepository,
            LocationRepository   $locationRepository,
            StopRepository       $stopRepository
        )
    {
        $this->connectionRepository = $connectionRepository;
        $this->locationRepository   = $locationRepository;
        $this->stopRepository       = $stopRepository;
    }

    /**
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Service\TransportInterface::getApiMethods()
     */
    public function getApiMethods()
    {
        return $this->apiMethods;
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Service\TransportInterface::getLocations($params)
     */
    public function getLocations(array $params = array())
    {
        return $this->get(self::LOCATION, $params);
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Service\TransportInterface::getConnections($params)
     */
    public function getConnections(array $params = array())
    {
        return $this->get(self::CONNECTION, $params);
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Service\TransportInterface::getStationboard($params)
     */
    public function getStationboard(array $params = array())
    {
        return $this->get(self::STOP, $params);
    }

    /**
     * @param string $apiMethod
     * @param array  $params
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Service\TransportInterface::get($apiMethod, $params)
     */
    public function get($apiMethod, array $params = array())
    {
        $this->validateMethodName($apiMethod);

        $repository = $this->getRepositoryByApiMethod($apiMethod);

        if ($repository === null || !($repository instanceof ApiAwareRepository)) {
            throw new RepositoryNotFoundException(
                sprintf('Transport API Method "%s" does not have a repository or is not configured to call the API', $apiMethod)
            );
        }

        return $repository->get($params);
    }

    /**
     * Validate the given API method: does it exist?
     *
     * @param string $apiMethod
     *
     * @throws UnknownApiMethodException
     */
    private function validateMethodName($apiMethod)
    {
        if (!in_array($apiMethod, array_keys($this->getApiMethods()))) {
            throw new UnknownApiMethodException(
                sprintf('Transport API Method %s does not exist', $apiMethod)
            );
        }
    }

    /**
     * Get a repository by a given method name
     *
     * @param string $apiMethod
     *
     * @return \Thormeier\TransportClientBundle\Repository\RepositoryInterface|null
     */
    private function getRepositoryByApiMethod($apiMethod)
    {
        switch ($apiMethod) {
            case self::CONNECTION:
                return $this->connectionRepository;
            case self::LOCATION:
                return $this->locationRepository;
            case self::STOP:
                return $this->stopRepository;
        }

        return null;
    }
}
