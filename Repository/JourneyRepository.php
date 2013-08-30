<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Model\Journey;

use Thormeier\TransportClientBundle\Repository\CheckpointRepository;
use Thormeier\TransportClientBundle\Repository\LocationRepository;

/**
 * Journey repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class JourneyRepository extends Repository
{
    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'to',
                'capacity1st',
                'capacity2nd',
                'category',
                'name',
                'number',
                'operator',
            );

    /**
     * @var CheckpointRepository
     */
    private $checkpointRepository;

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * Journey repository
     *
     * @param CheckpointRepository $checkpointRepository
     * @param LocationRepository   $locationRepository
     */
    public function __construct(CheckpointRepository $checkpointRepository, LocationRepository $locationRepository)
    {
        $this->checkpointRepository = $checkpointRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param array $data
     *
     * @return Journey
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        // Set up final destination as location entity
        $to = $this->locationRepository->get(array('query' => $data['to']));

        $journey = new Journey;
        $journey->setCapacity1st($data['capacity1st'])
            ->setCapacity2nd($data['capacity2nd'])
            ->setCategory($data['category'])
            ->setName($data['name'])
            ->setNumber($data['number'])
            ->setOperator($data['operator'])
            ->setTo($to[0]);

        foreach ($data['passList'] as $pass) {
            $journey->addPass($this->checkpointRepository->setUp($pass));
        }

        return $journey;
    }
}