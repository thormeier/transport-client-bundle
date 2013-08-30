<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Repository\ServiceRepository;

/**
 * Unit test for the service repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class ServiceRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    /**
     * Set up an instance of the repository class
     */
    public function setUp()
    {
        $this->serviceRepository = new ServiceRepository;
    }

    /**
     * Test setting up an entity
     */
    public function testSetUp()
    {
        $data = array(
                    'regular' => 'foo',
                    'irregular' => 'bar',
                );

        $result = $this->serviceRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Service', $result);
        $this->assertEquals($data['regular'], $result->getRegular());
        $this->assertEquals($data['irregular'], $result->getIrregular());
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->serviceRepository->setUp(array());
    }
}
