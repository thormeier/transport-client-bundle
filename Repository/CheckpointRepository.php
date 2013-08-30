<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Model\Checkpoint;

use Thormeier\TransportClientBundle\Repository\LocationRepository;
use Thormeier\TransportClientBundle\Repository\PrognosisRepository;

/**
 * Checkpoint repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class CheckpointRepository extends Repository
{
    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'prognosis',
                'station',
                'arrival',
                'departure',
                'delay',
                'platform',
            );

    /**
     * @var LocationRepository
     */
    private $locationRepository;

    /**
     * @var PrognosisRepository
     */
    private $prognosisRepository;

    /**
     * Checkpoint repository
     *
     * @param LocationRepository  $locationRepository
     * @param PrognosisRepository $prognosisRepository
     */
    public function __construct(LocationRepository $locationRepository, PrognosisRepository $prognosisRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->prognosisRepository = $prognosisRepository;
    }

    /**
     * @param array $data
     *
     * @return Checkpoint
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        // Set up prognosis
        $prognosis = $this->prognosisRepository->setUp($data['prognosis']);

        // Set up location
        $station = $this->locationRepository->setUp($data['station']);

        // Set up checkpoint entity itself
        $checkpoint = new Checkpoint;
        $checkpoint->setArrival(new \DateTime($data['arrival']))
            ->setDeparture(new \DateTime($data['departure']))
            ->setDelay($data['delay'])
            ->setPlatform($data['platform'])
            ->setPrognosis($prognosis)
            ->setStation($station);

        return $checkpoint;
    }
}
