<?php
namespace Thormeier\TransportClientBundle\Repository;

use Thormeier\TransportClientBundle\Entity\Coordinate;

/**
 * Coordinate repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class CoordinateRepository extends Repository
{
    /**
     * Array of keys that are necessary in the data array to set up an entity properly
     *
     * @var array
     */
    private $neededKeys = array(
                'x',
                'y',
                'type',
            );

    /**
     * @param array $data
     *
     * @return Coordinate
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        $this->validateDataPresence($data, $this->neededKeys);

        $coordinate = new Coordinate;
        $coordinate->setType($data['type'])
            ->setX($data['x'])
            ->setY($data['y']);

        return $coordinate;
    }
}
