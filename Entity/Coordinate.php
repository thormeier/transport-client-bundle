<?php
namespace Thormeier\TransportClientBundle\Entity;

/**
 * Entity class for coordinates
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Coordinate
{
    /**
     * Type of the given Coordinate
     *
     * @var string
     */
    private $type;

    /**
     * Latitude
     *
     * @var float
     */
    private $x;

    /**
     * Longitude
     *
     * @var float
     */
    private $y;

    /**
     * Set type
     *
     * @param string $type
     *
     * @return \Thormeier\TransportClientBundle\Entity\Coordinate
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Thormeier\TransportClientBundle\Entity\unknown
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set latitude
     *
     * @param float $x
     *
     * @return \Thormeier\TransportClientBundle\Entity\Coordinate
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return number
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set longitude
     *
     * @param float $y
     *
     * @return \Thormeier\TransportClientBundle\Entity\Coordinate
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return \Thormeier\TransportClientBundle\Entity\unknown
     */
    public function getY()
    {
        return $this->y;
    }
}
