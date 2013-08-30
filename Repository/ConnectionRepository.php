<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Exception\InsufficientParametersException;

use Thormeier\TransportClientBundle\Model\Location;
use Thormeier\TransportClientBundle\Model\Connection;

use Thormeier\TransportClientBundle\Repository\CheckpointRepository;
use Thormeier\TransportClientBundle\Repository\SectionRepository;
use Thormeier\TransportClientBundle\Repository\ServiceRepository;

/**
 * Connection repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ConnectionRepository extends ApiAwareRepository
{
    /**
     * Used to build the GET URL for the API
     *
     * @var string
     */
    const API_METHOD_NAME = 'connections';

    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'duration',
                'from',
                'to',
                'service',
                'capacity1st',
                'capacity2nd',
                'products',
                'sections',
            );

    /**
     * @var CheckpointRepository
     */
    private $checkpointRepository;

    /**
     * @var SectionRepository
     */
    private $sectionRepository;

    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * @param CheckpointRepository $checkpointRepository
     *
     * @return \Thormeier\TransportClientBundle\Repository\ConnectionRepository
     */
    public function setCheckpointRepository(CheckpointRepository $checkpointRepository)
    {
        $this->checkpointRepository = $checkpointRepository;

        return $this;
    }

    /**
     * @param SectionRepository $sectionRepository
     *
     * @return \Thormeier\TransportClientBundle\Repository\ConnectionRepository
     */
    public function setSectionRepository(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;

        return $this;
    }

    /**
     * @param ServiceRepository $serviceRepository
     *
     * @return \Thormeier\TransportClientBundle\Repository\ConnectionRepository
     */
    public function setServiceRepository(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return Connection
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        // Set up the duration as \DateInterval object
        $durationString = sprintf(str_replace(array('d', ':'), '%s', $data['duration']), ' days ', ' hours ', ' minutes ') . ' seconds';
        $duration = \DateInterval::createFromDateString($durationString);

        // Set up both "from" and "to" as Location entities
        $from = $this->checkpointRepository->setUp($data['from']);
        $to = $this->checkpointRepository->setUp($data['to']);

        // Set up service
        $service = $this->serviceRepository->setUp($data['service']);

        // Set up connection entity itself
        $connection = new Connection;
        $connection->setCapacity1st($data['capacity1st'])
            ->setCapacity2nd($data['capacity2nd'])
            ->setDuration($duration)
            ->setFrom($from)
            ->setService($service)
            ->setTo($to);

        foreach ($data['products'] as $product) {
            $connection->addProduct($product);
        }

        // Set up sections
        $sectionsArray = array();
        foreach ($data['sections'] as $section) {
            $connection->addSection($this->sectionRepository->setUp($section));
        }

        return $connection;
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
        $missingParameters = array();

        if (isset($params['from'])) {
            if ($params['from'] instanceof Location) {
                $params['from'] = $params['from']->getName();
            }
            $usedParams['from'] = $params['from'];
        } else {
            $missingParameters[] = 'from';
        }

        if (isset($params['to'])) {
            if ($params['to'] instanceof Location) {
                $params['to'] = $params['to']->getName();
            }
            $usedParams['to'] = $params['to'];
        } else {
            $missingParameters[] = 'to';
        }

        // Throw exception when not all required parameters are given
        if (count($missingParameters) > 0) {
            throw new InsufficientParametersException(
                sprintf(
                    InsufficientParametersException::MESSAGE,
                    implode('", "', $missingParameters),
                    __CLASS__
                )
            );
        }

        if (isset($params['via'])) {
            if (!is_array($params['via'])) {
                $params['via'] = array($params['via']);
            }

            $usedParams['via'] = array();
            foreach ($params['via'] as $via) {
                if ($via instanceof Location) {
                    $via = $via->getName();
                }
                $usedParams['via'][] = $via;
            }
        }

        if (isset($params['datetime']) && $params['datetime'] instanceof \DateTime) {
            $usedParams['date'] = $params['datetime']->format('Y-m-d');
            $usedParams['time'] = $params['datetime']->format('H:i');
        }

        if (isset($params['isArrivalTime'])) {
            $usedParams['isArrivalTime'] = (bool) $params['isArrivalTime'];
        }

        if (isset($params['transportations'])) {
            $usedParams['transportations'] = $params['transportations'];
        }

        if (isset($params['limit']) && $params['limit'] > 0) {
            $usedParams['limit'] = (int) $params['limit'];
        }

        if (isset($params['page']) && $params['page'] > 0) {
            $usedParams['page'] = (int) $params['page'];
        }

        if (isset($params['sleeper'])) {
            $usedParams['sleeper'] = (bool) $params['sleeper'];
        }

        if (isset($params['couchet'])) {
            $usedParams['couchet'] = (bool) $params['couchet'];
        }

        if (isset($params['bike'])) {
            $usedParams['bike'] = (bool) $params['bike'];
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
                    'from',
                    'to',
                    'via',
                    'datetime',
                    'isArrivalTime',
                    'transportations',
                    'limit',
                    'page',
                    'direct',
                    'sleeper',
                    'couchet',
                    'bike',
                );
    }
}
