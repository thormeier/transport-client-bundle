<?php
namespace Thormeier\TransportClientBundle\Entity;

use Thormeier\TransportClientBundle\Entity\Checkpoint;
use Thormeier\TransportClientBundle\Entity\Location;

use Thormeier\TransportClientBundle\Util\ArrayObjectHelper;

/**
 * Entity class for journeys
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Journey
{
    /**
     * Name of the journey
     *
     * @var string
     */
    private $name;

    /**
     * Category of the journey
     *
     * @var string
     */
    private $category;

    /**
     * Number of the journey
     *
     * @var integer
     */
    private $number;

    /**
     * Operator of the journey
     *
     * @var string
     */
    private $operator;

    /**
     * Final destination
     *
     * @var Location
     */
    private $to;

    /**
     * ArrayObject of Checkpoints
     *
     * @var \ArrayObject
     */
    private $passList;

    /**
     * Capacity of the first class
     *
     * @var integer
     */
    private $capacity1st;

    /**
     * Capacity of the second class
     *
     * @var integer
     */
    private $capacity2nd;

    /**
     * Entity class for journes
     */
    public function __construct()
    {
        $this->passList = new \ArrayObject;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return \Thormeier\TransportClientBundle\Entity\Journey
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
     * @return \Thormeier\TransportClientBundle\Entity\Journey
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
     * @return \Thormeier\TransportClientBundle\Entity\Journey
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
     * @return \Thormeier\TransportClientBundle\Entity\Journey
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
     * @return \Thormeier\TransportClientBundle\Entity\Journey
     */
    public function setTo(Location $to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get to
     *
     * @return \Thormeier\TransportClientBundle\Entity\Location
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Add checkpoint to passList
     *
     * @param Checkpoint $pass
     *
     * @return \Thormeier\TransportClientBundle\Entity\Journey
     */
    public function addPass(Checkpoint $pass)
    {
        $this->passList = ArrayObjectHelper::appendElement($this->passList, $pass);

        return $this;
    }

    /**
     * Remove checkpoint from passList
     *
     * @param Checkpoint $pass
     *
     * @return \Thormeier\TransportClientBundle\Entity\Journey
     */
    public function removePass(Checkpoint $pass)
    {
        $this->passList = ArrayObjectHelper::removeElement($this->passList, $pass);

        return $this;
    }

    /**
     * Get passList
     *
     * @return ArrayObject
     */
    public function getPassList()
    {
        return $this->passList;
    }

    /**
     * Set capacity1st
     *
     * @param integer $capacity1st
     *
     * @return \Thormeier\TransportClientBundle\Entity\Journey
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
     * @return \Thormeier\TransportClientBundle\Entity\Journey
     */
    public function setCapacity2nd($capacity2nd)
    {
        $this->capacity2nd = $capacity2nd;

        return $this;
    }

    /**
     * Get capacity2nd
     *
     * @return integer
     */
    public function getCapacity2nd()
    {
        return $this->capacity2nd;
    }
}
