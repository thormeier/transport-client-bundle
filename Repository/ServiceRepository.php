<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Entity\Service;

/**
 * Service repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ServiceRepository extends Repository
{
    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'irregular',
                'regular',
            );

    /**
     * @param array $data
     *
     * @return Service
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        $service = new Service;
        $service->setIrregular($data['irregular'])
            ->setRegular($data['regular']);

        return $service;
    }
}
