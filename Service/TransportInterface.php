<?php
namespace Thormeier\TransportClientBundle\Service;

use Thormeier\TransportClientBundle\Repository\Factory\RepositoryFactory;

/**
 * Interface for all public methods of the Transport service class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
interface TransportInterface
{
    /**
     * Get all possible API methods
     *
     * @return array
     */
    function getApiMethods();

    /**
     * Get an array of Locations by a given set of parameters
     *
     * @param array $params
     *
     * @return array
     */
    function getLocations(array $params = array());

    /**
     * Get an array of connections by a given set of parameters
     *
     * @param array $params
     *
     * @return array
     */
    function getConnections(array $params = array());

    /**
     * Get a stationboard by a given set of parameters
     *
     * @param array $params
     *
     * @return array
     */
    function getStationboard(array $params = array());

    /**
     * Get entities from the API via Repository classes
     *
     * @param string $apiMethod
     * @param array  $params
     *
     * @return array
     */
    function get($apiMethod, array $params = array());
}
