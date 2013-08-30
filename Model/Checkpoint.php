<?php
namespace Thormeier\TransportClientBundle\Model;

use Thormeier\TransportClientBundle\Model\Location;
use Thormeier\TransportClientBundle\Model\Prognosis;

/**
 * Model class for checkoints
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Checkpoint
{
    /**
     * The location of the checkpoint
     *
     * @var Location
     */
    private $station;

    /**
     * Arrival time
     *
     * @var \DateTime
     */
    private $arrival;

    /**
     * Departure time
     *
     * @var \DateTime
     */
    private $departure;

    /**
     * Delay in minutes
     *
     * @var integer
     */
    private $delay;

    /**
     * Platform
     *
     * @var integer
     */
    private $platform;

    /**
     * Prognosis
     *
     * @var Prognosis
     */
    private $prognosis;

    /**
     * Set station
     *
     * @param Location $station
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function setStation(Location $station)
    {
        $this->station = $station;

        return $this;
    }

    /**
     * Get station
     *
     * @return Location
     */
    public function getStation()
    {
        return $this->station;
    }

    /**
     * Set arrival
     *
     * @param \DateTime $arrival
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function setArrival(\DateTime $arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return unknown
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set departure
     *
     * @param \DateTime $departure
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function setDeparture(\DateTime $departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return unknown
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set delay
     *
     * @param integer $delay
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;

        return $this;
    }

    /**
     * Get delay
     *
     * @return integer
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Set platform
     *
     * @param integer $platform
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get platform
     *
     * @return integer
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set prognosis
     *
     * @param Prognosis $prognosis
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function setPrognosis(Prognosis $prognosis)
    {
        $this->prognosis = $prognosis;

        return $this;
    }

    /**
     * Get prognosis
     *
     * @return \Thormeier\TransportClientBundle\Model\Prognosis
     */
    public function getPrognosis()
    {
        return $this->prognosis;
    }
}
