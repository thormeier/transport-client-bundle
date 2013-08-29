<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Repository\ApiAwareRepository;

/**
 * Test implementation of an abstract class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ConcreteApiAwareRepository extends ApiAwareRepository
{
    /**
     * Mocked api method name
     *
     * @var string
     */
    const API_METHOD_NAME = 'method';

    /**
     * @param array $params
     *
     * @return array
     *
     * @see \Thormeier\TransportClientBundle\Repository\ApiAwareRepository::sanatizeParameters()
     */
    public function sanatizeParameters(array $params)
    {
        return $params;
    }

    /**
     * @param array $data
     *
     * @return \stdClass
     *
     * @see \Thormeier\TransportClientBundle\Repository\RepositoryInterface::setUp()
     */
    public function setUp(array $data)
    {
        return new \stdClass;
    }

    /**
     * @see \Thormeier\TransportClientBundle\Repository\ApiAwareRepositoryInterface::getPossibleParameters()
     *
     * @return array
     */
    public static function getPossibleParameters()
    {
        return array();
    }
}
