<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Model\Location;
use Thormeier\TransportClientBundle\Model\Coordinate;

use Thormeier\TransportClientBundle\Repository\CoordinateRepository;

use Thormeier\TransportClientBundle\Exception\InsufficientParametersException;

/**
 * Location repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class LocationRepository extends ApiAwareRepository
{
    /**
     * Used to build the GET URL for the API
     *
     * @var string
     */
    const API_METHOD_NAME = 'locations';

    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'coordinate',
                'distance',
                'name',
                'score',
            );

    /**
     * @var CoordinateRepository
     */
    private $coordinateRepository;

    /**
     * @param CoordinateRepository $coordinateRepository
     *
     * @return \Thormeier\TransportClientBundle\Repository\LocationRepository
     */
    public function setCoordinateRepository(CoordinateRepository $coordinateRepository)
    {
        $this->coordinateRepository = $coordinateRepository;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return Location
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        // Set up coordinate as Coordinate entity
        $coordinate = $this->coordinateRepository->setUp($data['coordinate']);

        // Set up location entity itself
        $location = new Location;
        $location->setCoordinate($coordinate)
            ->setDistance($data['distance'])
            ->setName($data['name'])
            ->setScore($data['score']);

        if (isset($data['id'])) {
            $location->setId($data['id']);
        }

        if (isset($data['type'])) {
            $location->setType($data['type']);
        }

        return $location;
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Repository\ApiAwareRepository::sanatizeParameters()
     */
    public function sanatizeParameters(array $params)
    {
        $usedParams = array();

        // Set up query parameter
        if (isset($params['query'])) {
            $usedParams['query'] = $params['query'];
        } else {
            throw new InsufficientParametersException(
                sprintf(
                    InsufficientParametersException::MESSAGE,
                    'query',
                    __CLASS__
                )
            );
        }

        // Set up location parameters
        if (isset($params['coordinate']) && $params['coordinate'] instanceof Coordinate) {
            $usedParams['x'] = $params['coordinate']->getX();
            $usedParams['y'] = $params['coordinate']->getY();
        } else {
            if (isset($params['x'])) {
                $usedParams['x'] = $params['x'];
            }

            if (isset($params['y'])) {
                $usedParams['y'] = $params['y'];
            }
        }

        // Set up type
        if (isset($params['type'])) {
            $usedParams['type'] = $params['type'];
        }

        return $usedParams;
    }

    /**
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Repository\ApiAwareRepositoryInterface::getPossibleParameters()
     */
    public static function getPossibleParameters()
    {
        return array(
                    'coordinate',
                    'x',
                    'y',
                    'query',
                    'type',
                );
    }
}
