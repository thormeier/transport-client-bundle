<?php
namespace Thormeier\TransportClientBundle\Entity;

use Thormeier\TransportClientBundle\Entity\Coordinate;

/**
 * Entity class for locations
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Location
{
    /**
     * ID of the location
     *
     * @var integer
     */
    private $id;

    /**
     * Type of the location
     *
     * @var string
     */
    private $type;

    /**
     * Name of the location
     *
     * @var string
     */
    private $name;

    /**
     * The accuracy of the query result
     *
     * @var float
     */
    private $score = 0.0;

    /**
     * Exact Coordinate
     *
     * @var Coordinate
     */
    private $coordinate;

    /**
     * The distance to the original point in meters
     *
     * @var integer
     */
    private $distance = 0;

    /**
     * Set ID
     *
     * @param integer $id
     *
     * @return \Thormeier\TransportClientBundle\Entity\Location
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get ID
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return \Thormeier\TransportClientBundle\Entity\Location
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return \Thormeier\TransportClientBundle\Entity\Location
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set score
     *
     * @param float $score
     *
     * @return \Thormeier\TransportClientBundle\Entity\Location
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set Coordinate
     *
     * @param Coordinate $coordinate
     *
     * @return \Thormeier\TransportClientBundle\Entity\Location
     */
    public function setCoordinate(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    /**
     * Get Coordinate
     *
     * @return \Thormeier\TransportClientBundle\Entity\Coordinate
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     *
     * @return \Thormeier\TransportClientBundle\Entity\Location
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return integer
     */
    public function getDistance()
    {
        return $this->distance;
    }
}
