<?php
namespace Thormeier\TransportClientBundle\Model;

/**
 * Model class for services
 *
 * As described in http://transport.opendata.ch/
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class Service
{
    /**
     * Information, about ow regular a connection operates
     *
     * @var string
     */
    private $regular;

    /**
     * Additional inforation on iregular operation dates
     *
     * @var string
     */
    private $irregular;

    /**
     * Set regular
     *
     * @param string $regular
     *
     * @return \Thormeier\TransportClientBundle\Model\Service
     */
    public function setRegular($regular)
    {
        $this->regular = $regular;

        return $this;
    }

    /**
     * Get regular
     *
     * @return string
     */
    public function getRegular()
    {
        return $this->regular;
    }

    /**
     * Set irregular
     *
     * @param string $irregular
     *
     * @return \Thormeier\TransportClientBundle\Model\Service
     */
    public function setIrregular($irregular)
    {
        $this->irregular = $irregular;

        return $this;
    }

    /**
     * Get irregular
     *
     * @return string
     */
    public function getIrregular()
    {
        return $this->irregular;
    }
}
