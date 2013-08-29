<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Entity\Location;
use Thormeier\TransportClientBundle\Entity\Stop;

use Thormeier\TransportClientBundle\Repository\LocationRepository;

use Thormeier\TransportClientBundle\Exception\InsufficientParametersException;

/**
 * Stop repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class StopRepository extends ApiAwareRepository
{
    /**
     * Used to build the GET URL for the API
     *
     * @var string
     */
    const API_METHOD_NAME = 'stationboard';

    /**
     * Key in the main response array where the requested station lies
     *
     * @var string
     */
    const STATION_KEY = 'station';

    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'station',
                'to',
                'category',
                'name',
                'number',
                'operator',
            );

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @param LocationRepository $locationRepository
     *
     * @return \Thormeier\TransportClientBundle\Repository\StopRepository
     */
    public function setLocationRepository(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;

        return $this;
    }

    /**
     * This method needs to be overwritten since there needs to be special behaviour when getting the station board
     *
     * @param array $params
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Repository\ApiAwareRepository::get()
     */
    public function get(array $params)
    {
        $params = $this->sanatizeParameters($params);

        $url = $this->buildUrl($params);
        $responseJson = $this->browser->get($url)->getContent();

        $responseArray = $this->serializer->deserialize($responseJson, 'array', 'json');

        $entities = array();
        foreach ($responseArray[$this->reponseArrayKey] as $entityData) {
            $entityData[self::STATION_KEY] = $responseArray[self::STATION_KEY];

            $entities[] = $this->setUp($entityData);
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Stop
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        // Set up station and to as Location entities
        $station = $this->locationRepository->setUp($data['station']);
        $to = $this->locationRepository->get(array('query' => $data['to']));

        // Set up Stop entity itself
        $stop = new Stop;
        $stop->setCategory($data['category'])
            ->setName($data['name'])
            ->setNumber($data['number'])
            ->setOperator($data['operator'])
            ->setStation($station)
            ->setTo($to[0]);

        return $stop;
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @throws InsufficientParametersException
     *
     * @see \Thormeier\TransportClientBundle\Repository\ApiAwareRepository::sanatizeParameters()
     */
    public function sanatizeParameters(array $params)
    {
        $usedParams = array();

        if (isset($params['station'])) {
            if ($params['station'] instanceof Location) {
                $params['station'] = $params['station']->getName();
            }

            $usedParams['station'] = $params['station'];
        } else {
            throw new InsufficientParametersException(
                sprintf(
                    InsufficientParametersException::MESSAGE,
                    'station',
                    __CLASS__
                )
            );
        }

        if (isset($params['id'])) {
            $usedParams['id'] = $params['id'];
        }

        if (isset($params['transportations'])) {
            $usedParams['transportations'] = $params['transportations'];
        }

        if (isset($params['datetime'])) {
            if ($params['datetime'] instanceof \DateTime) {
                $params['datetime'] = $params['datetime']->format('Y-m-d H:i');
            }

            $usedParams['datetime'] = $params['datetime'];
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
                    'station',
                    'id',
                    'transportations',
                    'datetime',
                );
    }
}
