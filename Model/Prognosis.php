<?php
namespace Thormeier\TransportClientBundle\Model;

/**
 * Model class for prognosis
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Prognosis
{
    /**
     * The estimated arrival/departure platform
     *
     * @var integer
     */
    private $platform;

    /**
     * Departure date time
     *
     * @var \DateTime
     */
    private $departure;

    /**
     * Arrival date time
     *
     * @var \DateTime
     */
    private $arrival;

    /**
     * The estimated occupation load of 1st class coaches
     *
     * @var integer
     */
    private $capacity1st;

    /**
     * The estimated occupation load of 2nd class coaches
     *
     * @var integer
     */
    private $capacity2nd;

    /**
     * Set platform
     *
     * @param integer $platform
     *
     * @return \Thormeier\TransportClientBundle\Model\Prognosis
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
     * Set departure
     *
     * @param \DateTime $departure
     *
     * @return \Thormeier\TransportClientBundle\Model\Prognosis
     */
    public function setDeparture(\DateTime $departure)
    {
        $this->departure = $departure;

        return $this;
    }

    /**
     * Get departure
     *
     * @return DateTime
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * Set arrival
     *
     * @param \DateTime $arrival
     *
     * @return \Thormeier\TransportClientBundle\Model\Prognosis
     */
    public function setArrival(\DateTime $arrival)
    {
        $this->arrival = $arrival;

        return $this;
    }

    /**
     * Get arrival
     *
     * @return DateTime
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * Set capacity1st
     *
     * @param integer $capacity1st
     *
     * @return \Thormeier\TransportClientBundle\Model\Prognosis
     */
    public function setCapacity1st($capacity1st)
    {
        $this->capacity1st = $capacity1st;

        return $this;
    }

    /**
     * Get capacity1st
     *
     * @return integer
     */
    public function getCapacity1st()
    {
        return $this->capacity1st;
    }

    /**
     * Set capacity2nd
     *
     * @param unknown $capacity2nd
     *
     * @return \Thormeier\TransportClientBundle\Model\Prognosis
     */
    public function setCapacity2nd($capacity2nd)
    {
        $this->capacity2nd = $capacity2nd;

        return $this;
    }

    /**
     * Get capacitySecond
     *
     * @return number
     */
    public function getCapacity2nd()
    {
        return $this->capacity2nd;
    }
}
