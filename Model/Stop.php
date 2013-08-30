<?php
namespace Thormeier\TransportClientBundle\Model;

use Thormeier\TransportClientBundle\Model\Location;

/**
 * Model class for stops
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Stop
{
    /**
     * A location showing this line's stop at the requested station
     *
     * @var Location
     */
    private $station;

    /**
     * Name of the connection
     *
     * @var string
     */
    private $name;

    /**
     * Type of the connection
     *
     * @var string
     */
    private $category;

    /**
     * Number of the connection's line
     *
     * @var integer
     */
    private $number;

    /**
     * The operator of the connection
     *
     * @var string
     */
    private $operator;

    /**
     * The final destination of this line
     *
     * @var Location
     */
    private $to;

    /**
     * Set station
     *
     * @param Location $station
     *
     * @return \Thormeier\TransportClientBundle\Model\Stop
     */
    public function setStation(Location $station)
    {
        $this->station = $station;

        return $this;
    }

    /**
     * Get station
     *
     * @return \Thormeier\TransportClientBundle\Model\Location
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return \Thormeier\TransportClientBundle\Model\Stop
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
     * Set category
     *
     * @param string $category
     *
     * @return \Thormeier\TransportClientBundle\Model\Stop
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return \Thormeier\TransportClientBundle\Model\Stop
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set operator
     *
     * @param string $operator
     *
     * @return \Thormeier\TransportClientBundle\Model\Stop
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set to
     *
     * @param Location $to
     *
     * @return \Thormeier\TransportClientBundle\Model\Stop
     */
    public function setTo(Location $to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return \Thormeier\TransportClientBundle\Model\Location
     */
    public function getTo()
    {
        return $this->to;
    }
}
