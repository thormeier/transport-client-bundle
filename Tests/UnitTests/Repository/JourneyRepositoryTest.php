<?php
namespace Thormeier\TransportClientBundle\Tests\Repository;

use Thormeier\TransportClientBundle\Entity\Location;
use Thormeier\TransportClientBundle\Entity\Checkpoint;

use Thormeier\TransportClientBundle\Repository\JourneyRepository;

/**
 * Unit test for the journey repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class JourneyRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JourneyRepository
     */
    private $journeyRepository;

    /**
     * Set up all needed repositories and their behaviour and set up an instance of the repository
     */
    public function setUp()
    {
        $locationRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\LocationRepository')
            ->setMethods(array(
                    'setUp',
                    'get',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $checkpointRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\CheckpointRepository')
            ->setMethods(array(
                    'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $locationRepository->expects($this->any())
            ->method('get')
            ->will($this->returnValue(array(new Location)));

        $checkpointRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Checkpoint));

        $this->journeyRepository = new JourneyRepository($checkpointRepository, $locationRepository);
    }

    /**
     * Test setting up an entity
     */
    public function testSetUp()
    {
        $data = array(
                    'to' => array(),
                    'capacity1st' => '1',
                    'capacity2nd' => '2',
                    'category' => 'foo',
                    'name' => 'bar',
                    'number' => 13,
                    'operator' => 'foo',
                    'passList' => array(
                                array(),
                                array(),
                                array(),
                            ),
                );

        $result = $this->journeyRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Journey', $result);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Entity\Location', $result->getTo());
        $this->assertEquals($data['capacity1st'], $result->getCapacity1st());
        $this->assertEquals($data['capacity2nd'], $result->getCapacity2nd());
        $this->assertEquals($data['category'], $result->getCategory());
        $this->assertEquals($data['name'], $result->getName());
        $this->assertEquals($data['operator'], $result->getOperator());
        $this->assertEquals($data['number'], $result->getNumber());

        $this->assertInstanceOf('ArrayObject', $result->getPassList());
        $this->assertCount(3, $result->getPassList());
        $this->assertContainsOnly('Thormeier\TransportClientBundle\Entity\Checkpoint', $result->getPassList());
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->journeyRepository->setUp(array());
    }
}
