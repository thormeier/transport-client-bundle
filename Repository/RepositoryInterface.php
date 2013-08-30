<?php
namespace Thormeier\TransportClientBundle\Repository;

/**
 * Interface for all reopository classes
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * Set up an entity
     *
     * @param array $data
     *
     * @return ambigious
     *
     * @return ambigious Model instance of respective repository with nested entities of other types
     */
    public function setUp(array $data);
}
