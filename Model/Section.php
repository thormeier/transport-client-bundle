<?php
namespace Thormeier\TransportClientBundle\Model;

use Thormeier\TransportClientBundle\Model\Journey;
use Thormeier\TransportClientBundle\Model\Checkpoint;

/**
 * Model class for sections
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Section
{
    /**
     * Journey entity
     *
     * @var Journey
     */
    private $journey;

    /**
     * Walk time in minutes
     *
     * @var integer
     */
    private $walk;

    /**
     * The departure Checkpoint
     *
     * @var Checkpoint
     */
    private $departure;

    /**
     * The arrival CHeckpoint
     *
     * @var Checkpoint
     */
    private $arrival;

    /**
     * Set journey
     *
     * @param Journey $journey
     *
     * @return \Thormeier\TransportClientBundle\Model\Section
     */
    public function setJourney(Journey $journey)
    {
        $this->journey = $journey;

        return $this;
    }

    /**
     * Get journey
     *
     * @return \Thormeier\TransportClientBundle\Model\Journey
     */
    public function getJourney()
    {
        return $this->journey;
    }

    /**
     * Set walk
     *
     * @param integer $walk
     *
     * @return \Thormeier\TransportClientBundle\Model\Section
     */
    public function setWalk($walk)
    {
        $this->walk = $walk;

        return $this;
    }

    /**
     * Get walk
     *
     * @return number
     */
    public function getWalk()
    {
        return $this->walk;
    }

    /**
     * Set departure
     *
     * @param Checkpoint $departure
     *
     * @return \Thormeier\TransportClientBundle\Model\Section
     */
    public function setDeparture(Checkpoint $departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set arrival
     *
     * @param Checkpoint $arrival
     *
     * @return \Thormeier\TransportClientBundle\Model\Section
     */
    public function setArrival(Checkpoint $arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function getArrival()
    {
        return $this->arrival;
    }
}
