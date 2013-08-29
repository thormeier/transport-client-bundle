<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Entity\Prognosis;

/**
 * PRognosis repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class PrognosisRepository extends Repository
{
    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'arrival',
                'capacity1st',
                'capacity2nd',
                'departure',
                'platform',
            );

    /**
     * @param array $data
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        $prognosis = new Prognosis;
        $prognosis->setArrival(new \DateTime($data['arrival']))
            ->setCapacity1st($data['capacity1st'])
            ->setCapacity2nd($data['capacity2nd'])
            ->setDeparture(new \DateTime($data['departure']))
            ->setPlatform($data['platform']);

        return $prognosis;
    }
}
