<?php
namespace Thormeier\TransportClientBundle\Tests\UnitTests\Repository;

use Thormeier\TransportClientBundle\Model\Journey;
use Thormeier\TransportClientBundle\Model\Checkpoint;

use Thormeier\TransportClientBundle\Repository\SectionRepository;

/**
 * Unit test for the section repository class
 *
 * @author Pascal Thormeier <pascal.thormeier@gmail.com>
 */
class SectionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SectionRepository
     */
    private $sectionRepository;

    /**
     * Mock all needed repositories and their behaviour and set up an instance of the repository class
     */
    public function setUp()
    {
        // Mock repositories that are to be injected into the tested one
        $journeyRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\JourneyRepository')
            ->setMethods(array(
                'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $checkpointRepository = $this->getMockBuilder('Thormeier\TransportClientBundle\Repository\CheckpointRepository')
            ->setMethods(array(
                'setUp',
            ))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        // Mock repository behaviour
        $journeyRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Journey));

        $checkpointRepository->expects($this->any())
            ->method('setUp')
            ->will($this->returnValue(new Checkpoint));

        // Set up repository that is to be tested
        $this->sectionRepository = new SectionRepository($checkpointRepository, $journeyRepository);
    }

    /**
     * Test setting up an entity
     */
    public function testSetUp()
    {
        $data = array(
                    'journey' => array(),
                    'arrival' => array(),
                    'departure' => array(),
                    'walk' => 12,
                );

        $result = $this->sectionRepository->setUp($data);

        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Section', $result);
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Journey', $result->getJourney());
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $result->getDeparture());
        $this->assertInstanceOf('Thormeier\TransportClientBundle\Model\Checkpoint', $result->getArrival());
        $this->assertEquals($data['walk'], $result->getWalk());
    }

    /**
     * Test throwing of InvalidDataException
     */
    public function testSetupInvalidKeys()
    {
        $this->setExpectedException('Thormeier\TransportClientBundle\Exception\InvalidDataException');

        $this->sectionRepository->setUp(array());
    }
}
