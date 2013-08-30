<?php
namespace Thormeier\TransportClientBundle\Model;

use Thormeier\TransportClientBundle\Model\Checkpoint;
use Thormeier\TransportClientBundle\Model\Service;
use Thormeier\TransportClientBundle\Model\Section;

use Thormeier\TransportClientBundle\Util\ArrayObjectHelper;

/**
 * Model class for connections
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Connection
{
    /**
     * Departure checkpoint of the connection
     *
     * @var Checkpoint
     */
    private $from;

    /**
     * Arrival checkpoint of the connection
     *
     * @var Checkpoint
     */
    private $to;

    /**
     * Duration of the journey
     *
     * @var \DateInterval
     */
    private $duration;

    /**
     * Service information about how regular the connection operates
     *
     * @var Service
     */
    private $service;

    /**
     * Array with transport products
     *
     * @var \ArrayObject
     */
    private $product;

    /**
     * Maximum estimated occupation load of 1st class coaches
     *
     * @var integer
     */
    private $capacity1st;

    /**
     * Sections of this connection
     *
     * @var \ArrayObject
     */
    private $section;

    /**
     * Maximum estimated occupation load of 2nd class coaches
     *
     * @var integer
     */
    private $capacity2nd;

    /**
     * Model class for connections
     */
    public function __construct()
    {
        $this->product = new \ArrayObject;
        $this->section = new \ArrayObject;
    }

    /**
     * Set from
     *
     * @param Checkpoint $from
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function setFrom(Checkpoint $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param Checkpoint $to
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function setTo(Checkpoint $to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return \Thormeier\TransportClientBundle\Model\Checkpoint
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set duration
     *
     * @param \DateInterval $duration
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function setDuration(\DateInterval $duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return DateInterval
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set service
     *
     * @param Service $service
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function setService(Service $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Thormeier\TransportClientBundle\Model\Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Add product
     *
     * @param string $product
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function addProduct($product)
    {
        $this->product = ArrayObjectHelper::appendElement($this->product, $product);

        return $this;
    }

    /**
     * Remove produkt
     *
     * @param string $product
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function removeProduct($product)
    {
        $this->product = ArrayObjectHelper::removeElement($this->product, $product);

        return $this;
    }

    /**
     * Get product
     *
     * @return ArrayObject
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add section
     *
     * @param Section $section
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function addSection($section)
    {
        $this->section = ArrayObjectHelper::appendElement($this->section, $section);

        return $this;
    }

    /**
     * Remove section
     *
     * @param Section $section
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
     */
    public function removeSection($section)
    {
        $this->section = ArrayObjectHelper::removeElement($this->section, $section);

        return $this;
    }

    /**
     * Get section
     *
     * @return ArrayObject
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set capacity1st
     *
     * @param integer $capacity1st
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
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
     * @param integer $capacity2nd
     *
     * @return \Thormeier\TransportClientBundle\Model\Connection
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
