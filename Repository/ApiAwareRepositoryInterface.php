<?php
namespace Thormeier\TransportClientBundle\Repository;

/**
 * Interface for all repositories that are able to call the API
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
interface ApiAwareRepositoryInterface
{
    /**
     * Get an array of entities by an array of given parameters
     *
     * @param array $params
     *
     * @return array
     */
    public function get(array $params);

    /**
     * Returns an array of all possible parameter keys
     *
     * @return array
     */
    public static function getPossibleParameters();
}
