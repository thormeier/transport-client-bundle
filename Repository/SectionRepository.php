<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Entity\Section;

use Thormeier\TransportClientBundle\Repository\CheckpointRepository;
use Thormeier\TransportClientBundle\Repository\JourneyRepository;

/**
 * Section repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class SectionRepository extends Repository
{
    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'journey',
                'arrival',
                'departure',
                'walk',
            );

    /**
     * @var CheckpointRepository
     */
    private $checkpointRepository;

    /**
     * @var JourneyRepository
     */
    private $journeyRepository;

    /**
     * Section repository
     *
     * @param CheckpointRepository $checkpointRepository
     * @param JourneyRepository    $journeyRepository
     */
    public function __construct(CheckpointRepository $checkpointRepository, JourneyRepository $journeyRepository)
    {
        $this->checkpointRepository = $checkpointRepository;
        $this->journeyRepository = $journeyRepository;
    }

    /**
     * @param array $data
     *
     * @return Section
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        // Set up journey entity
        $journey = $this->journeyRepository->setUp($data['journey']);

        // Set up both checkpoint entities
        $arrival = $this->checkpointRepository->setUp($data['arrival']);
        $departure = $this->checkpointRepository->setUp($data['departure']);

        $section = new Section;
        $section->setArrival($arrival)
            ->setDeparture($departure)
            ->setJourney($journey)
            ->setWalk($data['walk']);

        return $section;
    }
}